<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\Status;

class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        Status::updateCounts();
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        Status::updateCounts();
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        Status::updateCounts();
    }
}
