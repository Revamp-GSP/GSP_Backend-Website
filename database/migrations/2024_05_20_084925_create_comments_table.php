<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('user_id');
            $table->text('comment');
            $table->timestamps();
            
            // Tambahkan kunci asing untuk menghubungkan user_id ke tabel users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Optional: Index untuk peningkatan performa pencarian pada kolom task_id
            $table->index('task_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
