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
        Schema::create('status_trackings', function (Blueprint $table) {
            $table->id('tracking_id');
            $table->foreignId('proposal_id')->constrained('proposals', 'proposal_id')->onDelete('cascade');
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->foreignId('updated_by')->constrained('users', 'user_id')->onDelete('cascade');
            $table->timestamp('update_date')->useCurrent();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status_trackings');
    }
};
