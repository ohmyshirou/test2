<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->string('file_path')->nullable()->after('status'); // Letakkan sesuai urutan yang diinginkan
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('file_path');
        });
    }
};
