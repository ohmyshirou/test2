<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            // Hapus foreign key constraint
            $table->dropForeign(['approved_by']);

            // Hapus kolom
            $table->dropColumn('approved_by');
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            // Tambahkan kembali kolom
            $table->unsignedBigInteger('approved_by')->nullable();

            // Tambahkan kembali foreign key constraint
            $table->foreign('approved_by')->references('user_id')->on('users')->onDelete('cascade');
        });
    }
};
