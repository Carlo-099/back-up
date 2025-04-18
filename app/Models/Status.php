<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';
    protected $primaryKey = 'status_id';

    protected $fillable = [
        'title',
        'description',
        'category',
        'status',
        'due_date',
        'completed_at'
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime'
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
