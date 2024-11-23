<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->unsignedBigInteger('faculty_id')->nullable()->after('name');
            $table->foreign('faculty_id')->references('faculty_id')->on('faculties')->onDelete('cascade');
        });
    }
};
