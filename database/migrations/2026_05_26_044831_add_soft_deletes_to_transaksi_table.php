<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Nah, di sini kita tembak nama tabel lu yang bener: 'data_transaksi'
        Schema::table('data_transaksi', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('data_transaksi', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
