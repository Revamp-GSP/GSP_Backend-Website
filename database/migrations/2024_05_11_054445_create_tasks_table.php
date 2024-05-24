<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->string('program_kegiatan');
            $table->date('plan_date_start');
            $table->date('plan_date_end');
            $table->date('actual_date_start')->nullable();
            $table->date('actual_date_end')->nullable();
            $table->string('dokumen_output')->nullable();
            $table->string('pic');
            $table->string('divisi_terkait');
            $table->string('keterangan');
            $table->timestamps();
            
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
