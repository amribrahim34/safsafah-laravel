<?php

if (! function_exists('arabic_slug')) {
    /**
     * Generate a URL-friendly slug that preserves Arabic characters.
     * Replaces whitespace with hyphens and strips characters that are
     * not Arabic letters, alphanumerics, or hyphens.
     *
     * Example: "كريم تفتيح دير"  →  "كريم-تفتيح-دير"
     */
    function arabic_slug(string $text): string
    {
        // Replace any whitespace sequence with a single hyphen
        $slug = preg_replace('/\s+/u', '-', trim($text));
        // Remove characters that are not Arabic Unicode letters, ASCII alphanumerics, or hyphens
        $slug = preg_replace('/[^\p{Arabic}\p{L}\p{N}\-]/u', '', $slug);
        // Collapse multiple consecutive hyphens
        return preg_replace('/-{2,}/', '-', $slug);
    }
}
