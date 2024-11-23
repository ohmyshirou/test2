<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->id('proposal_id');
            $table->string('title');
            $table->text('description');
            $table->date('date_submitted');
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->foreignId('submitted_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};
