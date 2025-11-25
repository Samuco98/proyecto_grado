<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('consultas', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cliente_id');
        $table->unsignedBigInteger('mascota_id');
        $table->unsignedBigInteger('user_id');
        $table->text('motivo');
        $table->text('diagnostico')->nullable();
        $table->text('tratamiento')->nullable();
        $table->decimal('total', 10, 2)->default(0);
        $table->timestamp('fecha_consulta')->useCurrent();
        $table->timestamps();

        $table->foreign('cliente_id')->references('id')->on('clientes');
        $table->foreign('mascota_id')->references('id')->on('mascotas');
        $table->foreign('user_id')->references('id')->on('users');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
