<?php
// app/Models/Task.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'id','project_id', 'program_kegiatan', 'plan_date_start', 'plan_date_end',
        'actual_date_start', 'actual_date_end', 'dokumen_output', 'pic',
        'divisi_terkait', 'keterangan'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
