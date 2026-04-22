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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreignId("tenant_id")->constrained()->cascadeOnDelete();
            $table->foreignId("category_id")->nullable()->constrained()->nullOnDelete();

            $table->foreignId("ocupation_id")->nullable()->constrained()->nullOnDelete();
            $table->foreignId("ocupant_id")->nullable()->constrained("users")->nullOnDelete();
            $table->foreignId("technician_id")->nullable()->constrained("users")->nullOnDelete();

            $table->string('problem');
            $table->enum("priority", ['baixa', "media", "alta"])->nullable();
            $table->text("description")->nullable();

            $table->date("so_date")->nullable();
            $table->timestamp("done_at")->nullable();
            $table->enum("status", ["done", "pending", "expired", "cancelled"])->default("pending");

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
        Schema::dropIfExists('service_orders');
    }
};
