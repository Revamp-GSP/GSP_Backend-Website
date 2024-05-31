<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('comments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id');
        $table->unsignedBigInteger('user_id');
        $table->text('comment_text'); // Ubah nama kolom 'comment' menjadi 'comment_text' jika diinginkan
        $table->timestamps();
        
        // Tambahkan kunci asing untuk menghubungkan user_id ke tabel users
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        // Optional: Index untuk peningkatan performa pencarian pada kolom project_id
        $table->index('project_id');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
