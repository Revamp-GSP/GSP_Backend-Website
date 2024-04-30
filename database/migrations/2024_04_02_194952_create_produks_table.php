<?php

// create_produks_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProduksTable extends Migration
{
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('produk')->nullable();
            $table->string('id_service');
            $table->string('nama_service');
            $table->text('deskripsi')->nullable();
            $table->timestamp('date_added')->useCurrent();
            $table->timestamp('date_updated')->nullable();
            $table->string('created_by');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produks');
    }
}

