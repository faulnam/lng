<?php

if (!function_exists('app_image')) {
    /**
     * Resolve image URL handling relative public assets, storage paths, and external URLs seamlessly.
     *
     * @param string|null $path
     * @param string $fallback
     * @return string
     */
    function app_image(?string $path, string $fallback = 'images/lng/carrier.jpg'): string
    {
        if (empty($path)) {
            return asset(ltrim($fallback, '/'));
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $trimmed = ltrim($path, '/');

        if (str_starts_with($trimmed, 'storage/')) {
            return asset($trimmed);
        }

        if (str_starts_with($trimmed, 'images/')) {
            return asset($trimmed);
        }

        return asset('storage/' . $trimmed);
    }
}
