<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('proposals', function (Blueprint $table) {
        $table->enum('approval_status', ['Pending', 'Approved', 'Rejected'])->default('Pending')->after('status');
        $table->unsignedBigInteger('approved_by')->nullable()->after('approval_status');
        $table->foreign('approved_by')->references('user_id')->on('users')->onDelete('set null');
        $table->integer('revision_count')->default(0)->after('approval_status');
    });

    Schema::table('status_trackings', function (Blueprint $table) {
        $table->enum('action_type', ['Review', 'Approve', 'Reject'])->default('Review')->after('status');
    });
}

public function down()
{
    Schema::table('proposals', function (Blueprint $table) {
        $table->dropColumn(['approval_status', 'approved_by', 'revision_count']);
    });

    Schema::table('status_trackings', function (Blueprint $table) {
        $table->dropColumn('action_type');
    });
}

};
