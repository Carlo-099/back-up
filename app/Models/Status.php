<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'status_id';

    protected $fillable = [
        'pending',
        'in_progress',
        'complete'
    ];

    public static function updateCounts()
    {
        $counts = DB::table('tasks')
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        $status = self::first() ?? new self();
        $status->pending = $counts['pending'] ?? 0;
        $status->in_progress = $counts['in_progress'] ?? 0;
        $status->complete = $counts['complete'] ?? 0;
        $status->save();

        return $status;
    }
}
