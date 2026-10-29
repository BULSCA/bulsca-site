<?php

$app = require __DIR__.'/public-api-bootstrap.php';
\Illuminate\Support\Facades\Artisan::call('migrate:fresh', ['--force' => true]);
$data = \Tests\Support\PublicSiteFixture::create();
$club = 'test-university.'.$data['club']->id;
$comp = 'test-university-2026.'.$data['comp']->id;
$member = 'test-volunteer.'.$data['member']->id;
$article = $data['article']->getSlug();
$resource = $data['resource']->id;
$manifest = ['resource_id' => $resource, 'article_slug' => $article, 'paths' => [
    ['/', 'University lifesaving, together'], ['/latest', 'Test public news'], ['/article/'.$article, 'Published news.'],
    ['/get-involved/clubs', 'Test University'], ['/get-involved/clubs/'.$club, 'Weekly lifesaving training.'],
    ['/get-involved/committee', 'Test Volunteer'], ['/get-involved/previous-committees', 'Committee 2025-26'],
    ['/get-involved/committee/2025-26', 'Committee 2025-26'], ['/get-involved/committee/2026-27/'.$member, 'Volunteer biography.'],
    ['/competitions/calendar', 'Test University 2026'], ['/competitions/'.$comp, 'Test Pool'],
    ['/competitions/championships', 'Championships 2026'], ['/competitions/championships/2026', 'Championships 2026'],
    ['/competitions/championships/2023', 'Championships 2023'], ['/competitions/championships/2024', 'Championships 2024'], ['/competitions/championships/2025', 'Championships 2025'],
    ['/get-involved/committee/2026-27/test-volunteer', 'Coordinates the association.'],
    ['/competitions/league', 'A League'], ['/competitions/league/2025-26', 'Overall'], ['/competitions/previous-leagues', 'League 2025-26'],
    ['/resources', 'Competition documents'], ['/resources/competition-documents', 'Test entry pack'], ['/resources/view/'.$resource, 'Test entry pack'],
    ['/resources/search?q=safety', 'Test entry pack'], ['/resources/sercs', 'Pool practice'], ['/resources/sercs/pool-practice.'.$data['serc']->id, 'A team rescue scenario'],
    ['/resources/casualties', 'Test casualty'], ['/resources/casualties/test-casualty.'.$data['casualty']->id, 'Casualty briefing'],
    ['/contact-form', 'Contact BULSCA'],
]];
file_put_contents($argv[1], json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
echo "Isolated public API fixtures ready.\n";
