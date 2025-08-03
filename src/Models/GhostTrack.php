<?php
namespace Mayar\GhostTrack\Models;

use Illuminate\Database\Eloquent\Model;

class GhostLog extends Model
{
    protected $table = 'ghost_logs';

    protected $fillable = [
        'user_id', 'action', 'meta', 'ip_address', 'url', 'user_agent'
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}