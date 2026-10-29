#!/usr/bin/env python3
"""Normalize the production compose file with fake secrets; never start containers."""
import os
from pathlib import Path
import subprocess
import tempfile
import yaml


root = Path(__file__).resolve().parents[1]
fixture = {}
for line in (root / 'containers/release.env.example').read_text().splitlines():
    if line and not line.startswith('#'):
        key, value = line.split('=', 1)
        fixture[key] = value or 'ci-example'
fixture.update(BACKEND_TAG='ci-backend', FRONTEND_TAG='ci-frontend', APP_KEY='base64:' + 'A' * 43 + '=', DB_PASSWORD='ci-app-password', MYSQL_ROOT_PASSWORD='ci-root-password')
with tempfile.TemporaryDirectory(prefix='bulsca-compose-') as directory:
    env_file = Path(directory) / 'fixture.env'
    env_file.write_text(''.join(f'{key}={value}\n' for key, value in fixture.items()))
    env_file.chmod(0o600)
    result = subprocess.run(['podman-compose', '--env-file', str(env_file), '-f', str(root / 'compose.yml'), 'config'], cwd=root, env={**os.environ, **fixture}, capture_output=True, text=True)
    if result.returncode:
        raise SystemExit('Compose normalization failed. Run it locally with the fixture to inspect parser errors; no secrets printed.')
    config = yaml.safe_load(result.stdout)
    services = config['services']
    assert set(services) == {'frontend', 'backend', 'backend-web', 'scheduler', 'database'}
    for name in ('frontend', 'backend-web'):
        for port in services[name]['ports']:
            assert (isinstance(port, str) and port.startswith('127.0.0.1:')) or (isinstance(port, dict) and port['host_ip'] == '127.0.0.1'), 'Only loopback ports may be published'
    assert not services['database'].get('ports') and not services['backend'].get('ports')
    assert services['database']['image'] == 'docker.io/library/mysql:8.4'
    assert services['backend']['environment']['DB_USERNAME'] != 'root'
    assert 'MYSQL_ROOT_PASSWORD' not in services['backend']['environment']
    assert set(services['frontend']['environment']) == {'PUBLIC_API_HOST'}
    assert services['backend']['environment']['APP_DEBUG'] == 'false'
    assert services['backend']['environment']['PUBLIC_API_URL'] == 'https://api.bulsca.co.uk'
    args = services['frontend']['build']['args']
    if isinstance(args, list):
        args = dict(value.split('=', 1) for value in args)
    assert args['VITE_PUBLIC_DATA_MODE'] == 'live'
    assert all(volume['external'] for volume in config['volumes'].values())
    assert services['backend']['read_only']
    print('Compose normalization and release isolation checks passed using fake secrets; no containers started')
