import unittest
import xml.etree.ElementTree as ET
from pathlib import Path
from coverage_summary import summarise_coverage, percentage, markdown


class CoverageSummaryTest(unittest.TestCase):
    def document(self, files):
        root = Path.cwd()
        return ET.fromstring('<coverage><project>' + ''.join(f'<file name="{root / path}"><metrics statements="{total}" coveredstatements="{covered}"/></file>' for path, covered, total in files) + '</project></coverage>')

    def test_weighted_api_totals_include_untested_files(self):
        document = self.document([('app/Http/Controllers/Api/V1/Clubs.php', 1, 1), ('app/Http/Controllers/Api/V1/Other.php', 0, 99), ('app/Models/Club.php', 5, 10)])
        result = summarise_coverage(document, Path.cwd())
        self.assertEqual('1.00% (1/100)', percentage(result['Public API']))
        self.assertEqual('5.45% (6/110)', percentage(result['Total']))
        self.assertIn('Models and domain | 50.00%', markdown(result))

    def test_category_precedence_does_not_count_api_twice_as_legacy(self):
        result = summarise_coverage(self.document([('app/Http/Controllers/Api/V1/Clubs.php', 1, 2)]), Path.cwd())
        self.assertEqual({'covered': 0, 'total': 0}, result['Legacy web and authentication'])
        self.assertEqual({'covered': 1, 'total': 2}, result['Total'])

    def test_empty_category_is_not_claimed_as_fully_covered(self):
        self.assertEqual('N/A', percentage({'covered': 0, 'total': 0}))

    def test_missing_files_and_impossible_counts_fail(self):
        for document in [ET.fromstring('<coverage/>'), self.document([('app/Models/Club.php', 2, 1)])]:
            with self.assertRaises(ValueError):
                summarise_coverage(document, Path.cwd())

    def test_non_application_files_fail(self):
        with self.assertRaises(ValueError):
            summarise_coverage(self.document([('tests/TestCase.php', 1, 1)]), Path.cwd())


if __name__ == '__main__':
    unittest.main()
