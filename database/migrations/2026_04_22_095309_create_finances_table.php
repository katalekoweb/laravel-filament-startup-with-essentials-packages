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
        Schema::create('finances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->foreignId("category_id")->nullable()->constrained()->nullOnDelete();

            $table->foreignId("ocupation_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("ocupant_id")->nullable()->constrained("users")->nullOnDelete();

            $table->string('title');
            $table->enum("type", ['income', "expense"])->default("income");
            $table->text("description")->nullable();
            $table->decimal("amount", 10, 2);
            $table->decimal("paid")->default(0);
            $table->decimal("missing")->default(0);
            $table->decimal("fine")->default(0);
            $table->integer("number")->default(1);
            $table->date("expires_at")->nullable();
            $table->boolean("is_carnet")->default(false);

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
        Schema::dropIfExists('finances');
    }
};
