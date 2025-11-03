<?php
// app/Helpers/helpers.php

if (!function_exists('current_organization')) {
    /**
     * Get the current authenticated user's organization
     */
    function current_organization()
    {
        return auth()->user()?->organization;
    }
}

if (!function_exists('is_superadmin')) {
    /**
     * Check if current user is superadmin
     */
    function is_superadmin(): bool
    {
        return auth()->user()?->isSuperAdmin() ?? false;
    }
}

if (!function_exists('format_currency')) {
    /**
     * Format number as currency
     */
    function format_currency($amount, $currency = 'USD'): string
    {
        return $currency . ' ' . number_format($amount, 2);
    }
}

if (!function_exists('sanitize_phone')) {
    /**
     * Sanitize phone number
     */
    function sanitize_phone(?string $phone): ?string
    {
        if (!$phone) return null;
        return preg_replace('/[^0-9]/', '', $phone);
    }
}

if (!function_exists('hash_for_meta')) {
    /**
     * Hash data for Meta Conversion API
     */
    function hash_for_meta(?string $data): ?string
    {
        if (!$data) return null;
        return hash('sha256', strtolower(trim($data)));
    }
}