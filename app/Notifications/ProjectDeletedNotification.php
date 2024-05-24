<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectDeletedNotification extends Notification
{
    use Queueable;

    protected $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $message = $this->project ? "Project deleted: {$this->project->nama_pekerjaan}" : "A project has been deleted";
        
        return [
            'message' => $message,
            'project_id' => $this->project ? $this->project->id : null,
            'project_name' => $this->project ? $this->project->nama_pekerjaan : null,
        ];
    }
}
