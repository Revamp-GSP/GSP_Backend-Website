<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskDeletedNotification extends Notification
{
    use Queueable;

    protected $task;

    public function __construct($task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Task deleted :"' . $this->task->program_kegiatan . '" dalam daftar task "' . $this->task->nama_task . '" pada proyek "' . $this->task->project->nama_pekerjaan . '"',
            'task_id' => $this->task->id,
            'task_name' => $this->task->program_kegiatan,
            'nama_task' => $this->task->nama_task,
            'nama_pekerjaan' => $this->task->project->nama_pekerjaan,
        ];
    }
}
