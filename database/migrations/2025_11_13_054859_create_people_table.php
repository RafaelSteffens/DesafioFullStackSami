<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 120);
            $table->string('cpf', 11)->unique();
            $table->date('data_nascimento');
            $table->string('email', 190)->unique();
            $table->string('telefone', 20);
            $table->timestamps();
        });

    }


    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};
