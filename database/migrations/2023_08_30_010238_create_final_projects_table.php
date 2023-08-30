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
        Schema::create('final_projects', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('submitted_at');
            $table->string('title');
            $table->string('supervisor');
            $table->string('evaluator');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_project');
    }
};
