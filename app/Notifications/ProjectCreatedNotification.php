<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectCreatedNotification extends Notification
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

    public function toArray($notifiable)
    {
        $readAt = $this->readAt($notifiable); // Mendapatkan status baca notifikasi

        return [
            'message' => 'Project created: ' . $this->project->nama_pekerjaan,
            'project_id' => $this->project->id,
            'project_name' => $this->project->nama_pekerjaan,
            'read_at' => $readAt, // Menambahkan status baca notifikasi
        ];
    }

    protected function readAt($notifiable)
    {
        // Memeriksa apakah notifikasi telah dibaca
        if ($notifiable->readNotifications()->where('id', $this->id)->exists()) {
            return now()->toDateTimeString(); 
        }

        return null;
    }
}
