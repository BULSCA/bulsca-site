<?php

namespace Tests\Unit;

use App\Support\ArticleContent;
use PHPUnit\Framework\TestCase;

class ArticleContentTest extends TestCase
{
    public function test_it_preserves_safe_rich_content_and_unicode(): void
    {
        $html = (new ArticleContent)->sanitize('<h2>News</h2><p>Rescue café <strong>team</strong></p><a href="/resources">Read</a><img src="https://example.org/photo.jpg" alt="Team">');
        $this->assertStringContainsString('<strong>team</strong>', $html);
        $this->assertStringContainsString('café', $html);
        $this->assertStringContainsString('href="/resources"', $html);
        $this->assertStringContainsString('alt="Team"', $html);
    }

    public function test_it_drops_active_content_unsafe_urls_and_attributes(): void
    {
        $html = (new ArticleContent)->sanitize('<script>secret()</script><svg onload="bad()"><a>bad</a></svg><p style="color:red" onclick="bad()">Hello</p><a href="java&#x09;script:bad()">One</a><img src="data:text/html,bad" onerror="bad()"><a href="//evil.test">Two</a><iframe src="/bad"></iframe>');
        foreach (['script', 'secret', 'svg', 'onload', 'onclick', 'style=', 'onerror', 'data:', '//evil', 'iframe'] as $unsafe) {
            $this->assertStringNotContainsString($unsafe, $html);
        }
        $this->assertStringContainsString('<p>Hello</p>', $html);
    }

    public function test_malformed_markup_is_serialized_as_a_safe_new_tree(): void
    {
        $html = (new ArticleContent)->sanitize('<math><mtext><table><mglyph><style><!--</style><img title="--><img src=x onerror=bad()>">');
        $document = new \DOMDocument;
        $previous = libxml_use_internal_errors(true);
        try {
            $document->loadHTML('<html><body>'.$html.'</body></html>');
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
        $query = new \DOMXPath($document);
        $this->assertSame(0, $query->query('//script | //svg | //math | //iframe | //@*[starts-with(name(), "on")]')->length);
    }

    public function test_excerpts_remove_hidden_content_and_limit_words(): void
    {
        $content = new ArticleContent;
        $this->assertSame('Hello world & team', $content->excerpt('<p>Hello <strong>world</strong> &amp; team</p><script>bad()</script>'));
        $this->assertSame('One two...', $content->excerpt('<p>One two three</p>', 2));
        $this->assertSame('', $content->excerpt(''));
    }
}
