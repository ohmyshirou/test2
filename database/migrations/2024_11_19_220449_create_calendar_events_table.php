<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_events', function (Blueprint $table) {
            // Menambahkan kolom id sebagai primary key
            $table->id('event_id');
            
            // Relasi dengan tabel proposals
            $table->unsignedBigInteger('proposal_id'); 
            
            // Relasi dengan tabel users (misalnya, siapa yang membuat event)
            $table->unsignedBigInteger('created_by'); 
            
            // Timestamp untuk mencatat waktu pembuatan dan pembaruan
            $table->timestamps();

            // Membuat relasi foreign key untuk proposal_id
            $table->foreign('proposal_id')->references('proposal_id')->on('proposals')
                ->onDelete('cascade'); // Jika proposal dihapus, maka event ini juga dihapus

            // Membuat relasi foreign key untuk created_by
            $table->foreign('created_by')->references('user_id')->on('users')
                ->onDelete('cascade'); // Jika user dihapus, maka event ini juga dihapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendar_events');
    }
}
