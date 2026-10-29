#!/usr/bin/env python3
"""Exercise real Nginx templates against temporary files and a fake FastCGI app.

No asset/image builds, application database, mail or external HTTP are involved.
"""
import argparse
import http.client
import json
from pathlib import Path
import shutil
import socket
import socketserver
import struct
import subprocess
import tempfile
import threading
import time


def free_port():
    with socket.socket() as sock:
        sock.bind(('127.0.0.1', 0))
        return sock.getsockname()[1]


def exact(sock, size):
    data = b''
    while len(data) < size:
        block = sock.recv(size - len(data))
        if not block:
            raise EOFError()
        data += block
    return data


def length(data, position):
    if data[position] & 128:
        return struct.unpack('!I', data[position:position + 4])[0] & 0x7fffffff, position + 4
    return data[position], position + 1


class FastCGI(socketserver.BaseRequestHandler):
    def handle(self):
        params, body = b'', b''
        while True:
            _, kind, request_id, size, padding, _ = struct.unpack('!BBHHBB', exact(self.request, 8))
            content = exact(self.request, size)
            exact(self.request, padding)
            if kind == 4:
                params += content
            elif kind == 5:
                body += content
                if not size:
                    break
        env, position = {}, 0
        while position < len(params):
            key_size, position = length(params, position)
            value_size, position = length(params, position)
            key = params[position:position + key_size].decode()
            position += key_size
            env[key] = params[position:position + value_size].decode()
            position += value_size
        status = 404 if env.get('REQUEST_URI') == '/api/v1/missing' else 200
        payload = json.dumps({'env': env, 'body': body.decode()}).encode()
        output = f'Status: {status}\r\nContent-Type: application/json\r\nX-Request-ID: fixture-id\r\n\r\n'.encode() + payload
        for kind, data in [(6, output), (6, b''), (3, b'\0' * 8)]:
            self.request.sendall(struct.pack('!BBHHBB', 1, kind, request_id, len(data), 0, 0) + data)


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--frontend', type=Path, default=Path('../bulsca-frontend'))
    parser.add_argument('--nginx', default=shutil.which('nginx'))
    parser.add_argument('--fastcgi-params', type=Path, default=Path('/etc/nginx/fastcgi_params'))
    args = parser.parse_args()
    if not args.nginx or not args.fastcgi_params.is_file():
        parser.error('Install the Nginx binary and its fastcgi_params configuration')
    backend = Path(__file__).resolve().parents[1]
    frontend = args.frontend.resolve()
    checks = 0
    with tempfile.TemporaryDirectory(prefix='bulsca-nginx-') as temporary:
        root = Path(temporary)
        public, vue = root / 'public', root / 'vue'
        public.mkdir()
        vue.mkdir()
        (vue / 'index.html').write_text('<main>Vue shell fixture</main>')
        (vue / 'assets').mkdir()
        (vue / 'assets/app.js').write_text('/* static fixture, no build */')
        (public / 'storage').mkdir()
        (public / 'storage/test.txt').write_text('Public file fixture')
        (public / '.env').write_text('private-secret')
        front_port, back_port, php_port = free_port(), free_port(), free_port()
        values = {'PUBLIC_API_HOST': 'api.bulsca.co.uk', 'PORTAL_HOST': 'portal.bulsca.co.uk', 'NGINX_RESOLVERS': '127.0.0.1'}

        def render(source):
            value = source.read_text()
            for name, replacement in values.items():
                value = value.replace('${' + name + '}', replacement)
            return value

        php = render(backend / 'containers/php.conf').replace('/var/www/html/public', str(public)).replace('backend:9000', f'127.0.0.1:{php_port}').replace('include fastcgi_params;', f'include {args.fastcgi_params.resolve()};')
        (root / 'php.conf').write_text(php)
        back = render(backend / 'containers/default.conf.template').replace('listen 8080', f'listen {back_port}').replace('/etc/nginx/conf.d/bulsca/php.conf', str(root / 'php.conf'))
        front = render(frontend / 'containers/default.conf.template').replace('listen 8080', f'listen {front_port}').replace('/usr/share/nginx/html', str(vue)).replace('backend-web:8080', f'127.0.0.1:{back_port}')
        config = root / 'nginx.conf'
        config.write_text(f'daemon off;\npid {root}/nginx.pid;\nerror_log {root}/error.log;\nevents {{}}\nhttp {{\naccess_log off;\nclient_body_temp_path {root}/body;\nproxy_temp_path {root}/proxy;\nfastcgi_temp_path {root}/fastcgi;\nuwsgi_temp_path {root}/uwsgi;\nscgi_temp_path {root}/scgi;\n{back}\n{front}\n}}\n')
        subprocess.run([args.nginx, '-t', '-p', str(root), '-c', str(config)], check=True)
        process = subprocess.Popen([args.nginx, '-p', str(root), '-c', str(config)], stdout=subprocess.DEVNULL, stderr=subprocess.PIPE)
        fcgi = None

        def request(port, path, *, host='www.bulsca.co.uk', method='GET', body=None, headers=None):
            conn = http.client.HTTPConnection('127.0.0.1', port, timeout=4)
            try:
                conn.request(method, path, body=body, headers={'Host': host, **(headers or {})})
                response = conn.getresponse()
                return response.status, dict((key.lower(), value) for key, value in response.getheaders()), response.read().decode()
            finally:
                conn.close()

        def expect(port, path, status=200, **kwargs):
            nonlocal checks
            result = request(port, path, **kwargs)
            assert result[0] == status, (path, status, result)
            checks += 1
            return result

        try:
            for _ in range(100):
                if process.poll() is not None:
                    raise RuntimeError(process.stderr.read().decode())
                try:
                    request(front_port, '/health/live')
                    break
                except OSError:
                    time.sleep(0.05)
            expect(front_port, '/api/v1/clubs', 502)
            assert 'Vue shell fixture' in expect(front_port, '/competitions/championships')[2]
            fcgi = socketserver.ThreadingTCPServer(('127.0.0.1', php_port), FastCGI)
            threading.Thread(target=fcgi.serve_forever, daemon=True).start()
            for path in ['/api/v1/clubs?q=Test&page=2', '/img/portraits/a.jpg', '/resources/view/123', '/resources/view/12345678-1234-1234-1234-123456789abc']:
                status, headers, body = expect(front_port, path)
                data = json.loads(body)
                assert data['env']['REQUEST_URI'] == path
                assert data['env']['HTTP_HOST'] == 'api.bulsca.co.uk'
                assert headers['x-request-id'] == 'fixture-id'
            _, _, body = expect(front_port, '/api/v1/contact/submissions', method='POST', body='{"message":"hello"}', headers={'Content-Type': 'application/json', 'Cookie': 'session=private', 'Authorization': 'Bearer private', 'X-Forwarded-Proto': 'https'})
            data = json.loads(body)
            assert data['body'] == '{"message":"hello"}'
            assert not data['env'].get('HTTP_COOKIE') and not data['env'].get('HTTP_AUTHORIZATION')
            assert data['env']['HTTP_X_FORWARDED_PROTO'] == 'https'
            expect(front_port, '/api/v1/missing', 404)
            expect(front_port, '/assets/app.js')
            expect(front_port, '/assets/missing.js', 404)
            expect(front_port, '/missing.png', 404)
            expect(front_port, '/.env', 404)
            assert expect(front_port, '/storage/test.txt')[2] == 'Public file fixture'
            for path in ['/dashboard', '/auth/sso/callback', '/index.php', '/.env', '/img/upload', '/api/v2/clubs']:
                expect(back_port, path, 404 if path != '/img/upload' else 403, host='api.bulsca.co.uk', method='POST' if path == '/img/upload' else 'GET')
            expect(back_port, '/dashboard', host='portal.bulsca.co.uk')
            expect(back_port, '/auth/sso/callback?code=fixture', host='portal.bulsca.co.uk')
            expect(back_port, '/.env', 404, host='portal.bulsca.co.uk')
            expect(back_port, '/dashboard', 404, host='unrecognised.example')
            expect(back_port, '/health/live', host='api.bulsca.co.uk')
            expect(back_port, '/health/ready', host='api.bulsca.co.uk')
            print(f'Nginx routing: {checks} HTTP scenarios passed; no builds or external services')
        finally:
            process.terminate()
            process.wait(timeout=5)
            process.stderr.close()
            if fcgi:
                fcgi.shutdown()
                fcgi.server_close()


if __name__ == '__main__':
    main()
