#!/usr/bin/env python3
"""Summarise PHPUnit Clover line coverage without excluding untested legacy code."""
import argparse
import json
from pathlib import Path
import xml.etree.ElementTree as ET

CATEGORIES = [
    ('Public API', ('app/Http/Controllers/Api/', 'app/Http/Resources/')),
    ('Middleware and validation', ('app/Http/Middleware/', 'app/Http/Requests/', 'app/Exceptions/', 'app/Support/')),
    ('Services', ('app/Services/',)),
    ('Models and domain', ('app/Models/',)),
    ('Legacy web and authentication', ('app/Http/Controllers/',)),
    ('Console and scheduling', ('app/Console/',)),
    ('Other application code', ()),
]


def summarise_coverage(document, root):
    groups = {name: {'covered': 0, 'total': 0} for name, _ in CATEGORIES}
    groups['Total'] = {'covered': 0, 'total': 0}
    files = 0
    for entry in document.findall('.//file'):
        filename = Path(entry.attrib['name']).resolve().relative_to(Path(root).resolve()).as_posix()
        if not filename.startswith('app/'):
            raise ValueError('Coverage report contains a file outside app/')
        metrics = entry.find('metrics')
        total, covered = int(metrics.attrib['statements']), int(metrics.attrib['coveredstatements'])
        if not 0 <= covered <= total:
            raise ValueError('Invalid coverage counts')
        category = next((name for name, prefixes in CATEGORIES if filename.startswith(prefixes)), 'Other application code')
        for name in (category, 'Total'):
            groups[name]['covered'] += covered
            groups[name]['total'] += total
        files += 1
    if not files:
        raise ValueError('Coverage report contains no source files')
    return groups


def percentage(values):
    covered, total = values['covered'], values['total']
    return f'{100 * covered / total:.2f}% ({covered}/{total})' if total else 'N/A'


def markdown(groups):
    rows = '\n'.join(f'| {name} | {percentage(values)} |' for name, values in groups.items())
    return '# Backend test coverage\n\nPHPUnit unit/feature line coverage includes all app/ source files, including untested legacy features. PCOV does not measure branch/path coverage. Browser integration runs separately.\n\n| Category | Lines |\n| --- | --- |\n' + rows + '\n\nDownload the backend-coverage artifact for the HTML report (html/index.html), Clover XML and machine-readable summaries. Reports describe this run and commit.\n'


def main():
    parser = argparse.ArgumentParser(description=__doc__)
    parser.add_argument('report', type=Path)
    parser.add_argument('--root', type=Path, default=Path.cwd())
    args = parser.parse_args()
    groups = summarise_coverage(ET.parse(args.report).getroot(), args.root)
    summary = markdown(groups)
    (args.report.parent / 'category-summary.json').write_text(json.dumps(groups, indent=2) + '\n')
    (args.report.parent / 'category-summary.md').write_text(summary)
    print(summary)


if __name__ == '__main__':
    main()
