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
        Schema::create('voter_sessions', function (Blueprint $table) {
            $table->id();
            // A voter may have their own voting session on a device
            $table->foreignId('voter_id')->constrained('voters')->cascadeOnDelete();
            // session id for a voter
            $table->string('session_id')->unique();
            // Optional device information where the voter is online
            $table->string('device_info')->nullable();
            // ip address of the voter
            $table->string('ip_address')->nullable();
            // last active time of the voter
            $table->dateTime('last_activity');
            // whether the session is active or not
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voter_sessions');
    }
};
