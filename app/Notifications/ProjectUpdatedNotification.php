<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class ProjectUpdatedNotification extends Notification
{
    use Queueable;

    protected $project;
    protected $changes;
    protected $appType;

    public function __construct($project, $changes)
    {
        $this->project = $project;
        $this->changes = $changes;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Project updated: {$this->project->nama_pekerjaan}",
            'project_id' => $this->project->id,
            'project_name' => $this->project->nama_pekerjaan,
            'changes' => $this->changes,
            'app_type' => $this->appType,
        ];
    }
}
