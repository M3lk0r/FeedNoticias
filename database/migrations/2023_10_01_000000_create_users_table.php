<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            // Campos para autenticação via OAuth (Microsoft)
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            // Campo para diferenciar funções: 'admin' ou 'user'
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->timestamps();
            $table->rememberToken();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}