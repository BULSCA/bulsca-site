"""Generate the committed Vue contract types from our OpenAPI JSON, without dependencies.

Run with --check for drift detection. Unsupported schema forms fail closed.
"""
import argparse
import hashlib
import json
from pathlib import Path

ROOT = Path(__file__).resolve().parents[1]


def typescript(schema):
    if '$ref' in schema:
        return schema['$ref'].rsplit('/', 1)[1]
    if 'const' in schema:
        return json.dumps(schema['const'])
    if 'enum' in schema:
        return ' | '.join(json.dumps(value) for value in schema['enum'])
    kind = schema.get('type')
    if isinstance(kind, list):
        return ' | '.join(typescript(dict(schema, type=value)) for value in kind)
    if kind in ('string', 'boolean', 'null'):
        return kind
    if kind in ('integer', 'number'):
        return 'number'
    if kind == 'array':
        return f'Array<{typescript(schema["items"])}>'
    if kind == 'object':
        fields = [f'{json.dumps(key)}{"" if key in schema.get("required", []) else "?"}: {typescript(value)}'
                  for key, value in schema.get('properties', {}).items()]
        additional = schema.get('additionalProperties')
        if isinstance(additional, dict):
            fields.append(f'[key: string]: {typescript(additional)}')
        return '{ ' + '; '.join(fields) + ' }'
    raise ValueError(f'Unsupported schema: {schema}')


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('--check', action='store_true')
    parser.add_argument('--output', type=Path, default=ROOT.parent / 'bulsca-frontend/src/api/generated.ts')
    args = parser.parse_args()
    raw = (ROOT / 'docs/api/openapi.json').read_bytes()
    spec = json.loads(raw)
    output = '// Generated from BULSCA/bulsca-site docs/api/openapi.json. Do not edit.\n'
    output += f'// Contract SHA-256: {hashlib.sha256(raw).hexdigest()}\n\n'
    output += '\n'.join(f'export type {name} = {typescript(schema)}' for name, schema in spec['components']['schemas'].items()) + '\n'
    if args.check:
        if not args.output.exists() or args.output.read_text() != output:
            raise SystemExit('API types differ: regenerate and commit both contract and frontend changes.')
        print('API types match the committed contract.')
    else:
        args.output.parent.mkdir(parents=True, exist_ok=True)
        args.output.write_text(output)
        print(f'Updated {args.output}')


if __name__ == '__main__':
    main()
