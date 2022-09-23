<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('education_institutions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();
            $table->string('institution')->nullable();
            $table->string('field_of_study')->nullable();
            $table->string('degree')->nullable();
            $table->boolean('currently_attending')->nullable();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education_institutions');
    }
};
