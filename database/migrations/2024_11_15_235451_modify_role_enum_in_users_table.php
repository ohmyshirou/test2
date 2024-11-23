<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyRoleEnumInUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Modify the role column to include new roles
            $table->enum('role', ['advisor', 'student_governing', 'student_organization'])->change();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert back to the original ENUM values
            $table->enum('role', ['BKAL', 'BPM', 'Organisasi', 'advisor', 'student_governing', 'student_organization'])->change();
        });
    }
}
