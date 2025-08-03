<?php
if (!function_exists('ghost_log')) {
    function ghost_log(string $action, array $meta = []): void
    {
        \Mayar\GhostTrack\Facades\GhostTrack::log($action, $meta);
    }
}
