<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskUpdatedNotification extends Notification
{
    use Queueable;

    protected $task;
    protected $changes;

    public function __construct($task, $changes)
    {
        $this->task = $task;
        $this->changes = $changes;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Task Updated :"' . $this->task->program_kegiatan . '" dalam daftar task "' . $this->task->nama_task . '" pada proyek "' . $this->task->project->nama_pekerjaan . '"',
            'task_id' => $this->task->id,
            'task_name' => $this->task->nama_task,
            'program_kegiatan' => $this->task->program_kegiatan,
            'nama_pekerjaan' => $this->task->project->nama_pekerjaan,
            'changes' => $this->changes,
        ];
    }
}
