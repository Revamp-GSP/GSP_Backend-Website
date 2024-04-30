<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customers extends Model
{
    use HasFactory;
    protected $fillable = ['id_pelanggan', 'nama_pelanggan', 'sebutan', 'created_by'];

    protected static function booted()
    {
        static::updating(function ($produk) {
            $produk->date_updated = now();
        });
    }
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
