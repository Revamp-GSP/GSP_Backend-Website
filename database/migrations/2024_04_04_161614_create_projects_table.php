<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->unsignedBigInteger('customer_id')->nullable()->default(null);
            $table->string('nama_pelanggan');
            $table->unsignedBigInteger('product_id')->nullable()->default(null);
            $table->string('nama_service');
            $table->string('nama_pekerjaan');
            $table->decimal('nilai_pekerjaan_rkap', 15, 2);
            $table->decimal('nilai_pekerjaan_aktual', 15, 2);
            $table->decimal('nilai_pekerjaan_kontrak_tahun_berjalan', 15, 2);
            $table->date('plan_start_date')->nullable();
            $table->date('plan_end_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_end_date')->nullable();
            $table->string('account_marketing');
            $table->string('dirut')->nullable();
            $table->string('dirop')->nullable();
            $table->string('dirke')->nullable();
            $table->string('kskmr')->nullable();
            $table->string('ksham')->nullable();
            $table->string('msdmu')->nullable();
            $table->string('mkakt')->nullable();
            $table->string('mbilp')->nullable();
            $table->string('mppti')->nullable();
            $table->string('mopti')->nullable();
            $table->string('mbsar')->nullable();
            $table->string('msadb')->nullable();
            $table->timestamps();
        
            // Menambahkan constraint foreign key untuk customer_id dan product_id
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
