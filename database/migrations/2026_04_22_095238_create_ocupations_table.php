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
        Schema::create('ocupations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->foreignId("ocupant_id")->constrained("users")->cascadeOnDelete();
            $table->foreignId("unit_id")->constrained()->cascadeOnDelete();

            $table->foreignId("order_id")->nullable()->constrained()->nullOnDelete();

            $table->text('notes');
            $table->enum("type", ['buy', 'rent'])->default("rent");
            $table->enum("period", ['daily', "monthly"])->default("monthly");
            $table->date("expire_at")->nullable();
            $table->enum("status", ['active', 'pending', 'expired'])->default("active");
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
        Schema::dropIfExists('ocupations');
    }
};
