<?php
namespace Mayar\GhostTrack;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mayar\GhostTrack\Jobs\StoreGhostLogJob;
use Mayar\GhostTrack\Models\GhostLog;

class GhostTrack
{
    public function log(string $action, array $meta = []): void
    {
        if (!config('ghosttrack.enabled')) return;

        $data = [
            'user_id' => Auth::id(),
            'action' => $action,
            'meta' => $meta,
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
            'user_agent' => request()->userAgent(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        match (config('ghosttrack.driver')) {
            'log' => Log::channel('daily')->info('GhostTrack', $data),
            'cache' => Cache::put('ghost_log_'.Str::uuid(), $data, now()->addMinutes(5)),
            'database' => config('ghosttrack.queue')
                ? StoreGhostLogJob::dispatch($data)
                : GhostLog::create($data),
            default => null,
        };
    }
}
