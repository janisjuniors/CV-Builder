<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('work_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->string('job_title')->nullable();
            $table->string('employer')->nullable();
            $table->text('description')->nullable();
            $table->date('start');
            $table->date('end');
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_history');
    }
};
