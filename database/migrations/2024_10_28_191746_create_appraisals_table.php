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
        Schema::create('appraisals', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('property_address');
            $table->decimal('property_price', 15, 2)->nullable();
            $table->text('comments')->nullable();
            $table->enum('status', ['Solicitado', 'En proceso', 'Tasación completada', 'Rechazado'])->default('Solicitado');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');          
            $table->unsignedBigInteger('managed_by_user')->nullable(); // who's administrating this appraisal
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');     
            $table->datetime('next_appointment')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appraisals');
    }
};
