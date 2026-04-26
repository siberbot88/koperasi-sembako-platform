<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

/**
 * SupportSession
 *
 * Stores AI Customer Service conversation logs per session.
 * Used for audit, escalation handoff, and future analytics.
 */
class SupportSession extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'support_sessions';

    protected $fillable = [
        'session_key',  // PHP session ID
        'user_id',      // null if guest
        'messages',     // array of { role, content, timestamp }
        'status',       // active | closed | escalated
        'escalated_at',
    ];

    protected function casts(): array
    {
        return [
            'messages'     => 'array',
            'escalated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
