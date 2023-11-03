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
        Schema::create('hakis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('faculty')->nullable();
            $table->string('type')->nullable();
            $table->string('status')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('haki_no')->nullable();
            $table->string('registered_at')->nullable();
            $table->string('scale')->nullable();
            $table->year('year')->nullable();
            $table->string('link', 2000)->nullable();
            $table->text('output')->nullable();
            $table->string('haki_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hakis');
    }
};
