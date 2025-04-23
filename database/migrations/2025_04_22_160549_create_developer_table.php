<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('developers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('developer');
    }
};
