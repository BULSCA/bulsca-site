<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;

/** Copies approved content into a fresh DOM; legacy HTML is never returned directly. */
class ArticleContent
{
    private const ELEMENTS = ['p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'blockquote',
        'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li', 'a', 'img', 'hr', 'pre', 'code',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td', 'caption', 'figure', 'figcaption'];

    private const DROP = ['script', 'style', 'iframe', 'object', 'embed', 'svg', 'math',
        'template', 'form', 'input', 'button', 'textarea', 'select', 'noscript', 'link', 'meta'];

    public function sanitize(string $html): string
    {
        if ($html === '') {
            return '';
        }

        $source = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        try {
            $source->loadHTML('<!doctype html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body>'.$html.'</body></html>', LIBXML_NONET);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        $output = new DOMDocument('1.0', 'UTF-8');
        $root = $output->appendChild($output->createElement('div'));
        $body = $source->getElementsByTagName('body')->item(0);
        if ($body) {
            foreach ($body->childNodes as $node) {
                $this->copy($node, $root, $output);
            }
        }

        $result = '';
        foreach ($root->childNodes as $node) {
            $result .= $output->saveHTML($node);
        }
        return $result;
    }

    public function excerpt(string $html, int $words = 80): string
    {
        $plain = html_entity_decode(strip_tags(str_replace('<', ' <', $this->sanitize($html))), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $plain = trim(preg_replace('/\s+/u', ' ', $plain) ?? '');
        $parts = preg_split('/\s+/u', $plain, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        return implode(' ', array_slice($parts, 0, $words)).(count($parts) > $words ? '...' : '');
    }

    private function copy(DOMNode $source, DOMNode $parent, DOMDocument $output): void
    {
        if ($source instanceof DOMText) {
            $parent->appendChild($output->createTextNode($source->textContent));
            return;
        }
        if (! $source instanceof DOMElement || in_array(strtolower($source->tagName), self::DROP, true)) {
            return;
        }

        $name = strtolower($source->tagName);
        $target = $parent;
        if (in_array($name, self::ELEMENTS, true)) {
            $target = $parent->appendChild($output->createElement($name));
            foreach (['title', 'alt'] as $attribute) {
                if ($source->hasAttribute($attribute)) {
                    $target->setAttribute($attribute, $source->getAttribute($attribute));
                }
            }
            $attribute = $name === 'a' ? 'href' : ($name === 'img' ? 'src' : null);
            if ($attribute && $source->hasAttribute($attribute)) {
                $url = trim($source->getAttribute($attribute));
                if ($this->safeUrl($url, $name === 'a')) {
                    $target->setAttribute($attribute, $url);
                }
            }
            if ($name === 'a') {
                $target->setAttribute('rel', 'noopener noreferrer');
            }
            if ($name === 'img') {
                $target->setAttribute('loading', 'lazy');
            }
            foreach (['colspan', 'rowspan'] as $attribute) {
                if (in_array($name, ['td', 'th'], true) && preg_match('/^[1-9]\d?$/', $source->getAttribute($attribute))) {
                    $target->setAttribute($attribute, $source->getAttribute($attribute));
                }
            }
        }
        foreach ($source->childNodes as $child) {
            $this->copy($child, $target, $output);
        }
    }

    private function safeUrl(string $url, bool $link): bool
    {
        if ($url === '' || preg_match('/[\x00-\x20\x7f\\\\]/', $url) || str_starts_with($url, '//')) {
            return false;
        }
        if (preg_match('/^([a-z][a-z0-9+.-]*):/i', $url, $matches)) {
            return in_array(strtolower($matches[1]), $link ? ['http', 'https', 'mailto'] : ['http', 'https'], true);
        }
        // A colon in the first path segment would be interpreted as a URI scheme.
        return ! str_contains(explode('/', $url, 2)[0], ':');
    }
}
