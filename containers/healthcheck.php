<?php

$host = getenv('PUBLIC_API_HOST') ?: 'api.bulsca.co.uk';
if (! preg_match('/^[a-zA-Z0-9.-]+$/', $host)) exit(1);
$context = stream_context_create(['http' => ['timeout' => 4, 'header' => "Host: $host\r\n", 'ignore_errors' => true]]);
$body = @file_get_contents('http://backend-web:8080/health/ready', false, $context);
exit($body !== false && str_contains($http_response_header[0] ?? '', ' 200 ') ? 0 : 1);
