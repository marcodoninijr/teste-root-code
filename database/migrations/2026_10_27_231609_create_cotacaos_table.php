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
    Schema::create('cotacaos', function (Blueprint $table) {
        $table->id();
        
        // Dados de Entrada[cite: 1, 2]
        $table->string('nome');
        $table->date('data_nascimento');
        $table->string('destino');
        $table->date('data_inicio');
        $table->date('data_fim');
        $table->boolean('bagagem')->default(false);

        // Valores Calculados[cite: 3, 4]
        $table->integer('dias_cobrados');
        $table->integer('idade');
        $table->decimal('valor_base', 10, 2);
        $table->decimal('subtotal', 10, 2);
        $table->decimal('valor_bagagem', 10, 2)->default(0);
        $table->decimal('total', 10, 2);
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotacaos');
    }
};
