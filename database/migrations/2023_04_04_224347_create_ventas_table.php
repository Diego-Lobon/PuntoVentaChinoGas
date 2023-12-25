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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idCliente')->nullable();
            $table->unsignedBigInteger('idVendedor');
            $table->unsignedBigInteger('idProducto');
            $table->string('nombreCliente');
            $table->string('nombreVendedor');
            $table->string('direccion');
            $table->string('celular');
            $table->string('cantidad');
            $table->string('nombreProducto');
            $table->float('precioUnitario');
            $table->string('tipoCliente');
            $table->string('tipoPago');
            $table->float('total');
            $table->timestamps();
            $table->foreign('idCliente')->references('id')->on('clientes');
            $table->foreign('idVendedor')->references('id')->on('users');
            $table->foreign('idProducto')->references('id')->on('inventarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
