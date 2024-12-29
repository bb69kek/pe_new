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
        Schema::create('halts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('user_id')->constrained(); 

            $table->string('name');
            $table->string('method');
            $table->integer('slots');
            $table->string('day');
            $table->string('hour');
            $table->string('target');
            $table->integer('port');
            $table->string('packets')->nullable();
            $table->string('downtime')->nullable();
            $table->string('haltStart')->nullable();
            $table->string('haltEnd')->nullable();
            $table->string('lastDown')->nullable();
            $table->integer('duration');
            $table->string('dataSent')->default(0);
            $table->string('randomPorts')->nullable();
            $table->string('status');
            $table->string('mode')->nullable();

            $table->string('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halts');
    }
};
