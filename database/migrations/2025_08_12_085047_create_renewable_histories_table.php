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
        Schema::create('renewable_histories', function (Blueprint $table) {
            $table->id();
           $table->foreignId('renewable_id')->nullable();
          $table->foreign('renewable_id')->references('id')->on('renewables')->onDelete('cascade');

          $table->foreignId('vehicle_id')->nullable();
          $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');

          $table->foreignId('document_type_id')->nullable();
          $table->foreign('document_type_id')->references('id')->on('document_types')->onDelete('cascade');


            

            // Old record dates
            $table->date('renewable_date');
            $table->date('expired_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('renewable_histories');
    }
};
