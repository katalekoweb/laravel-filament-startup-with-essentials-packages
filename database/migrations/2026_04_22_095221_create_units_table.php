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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->foreignId("section_id")->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->enum("tipology", ["t1", "t2", "t3", "t4", "t5", "t5+"])->nullable();
            $table->string("slug")->nullable()->unique();
            $table->decimal("sell_price", 15, 2)->nullable();
            $table->decimal("month_rent_price", 15, 2)->nullable();
            $table->decimal("daily_rent_price", 15, 2)->nullable();
            $table->string("photo")->nullable();
            $table->string("photo2")->nullable();
            $table->string("photo3")->nullable();

            // Estado da Unidade
            $table->enum('status', [
                'available',    // Disponível
                'rented',       // Alugado
                'sold',         // Comprado/Vendido
                'maintenance',  // Em manutenção
                'reserved'      // Reservado (ex: para eventos)
            ])->default('available')->after('is_active');

            // Tipo de Unidade
            $table->enum('category', [
                'house',        // Casa/Apto
                'room',         // Sala Comercial/Escritório
                'leisure',      // Área de Lazer (Piscina, Churrasqueira)
                'event',        // Salão de Festas/Conferência
                'sport',        // Campo/Quadra
                'parking'       // Estacionamento
            ])->default('house')->after('status');

            $table->boolean("is_active")->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
