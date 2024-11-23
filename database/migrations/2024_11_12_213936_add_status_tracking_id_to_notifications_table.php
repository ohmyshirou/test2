<?php

// database/migrations/xxxx_xx_xx_xxxxxx_add_status_tracking_id_to_notifications_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusTrackingIdToNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Menambahkan foreign key constraint jika kolom sudah ada
            $table->foreign('status_tracking_id')->references('tracking_id')->on('status_trackings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropForeign(['status_tracking_id']);  // Menghapus foreign key
        });
    }
}


