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
        Schema::create('invoice_fruit', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('invoice_id')->unsigned();
            $table->bigInteger('fruit_id')->unsigned();
            $table->double('quantity', 8, 2);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('invoice_id')->references('id')
            ->on('invoice')
            ->onDelete('cascade')
            ->onUpdate('cascade');

            $table->foreign('fruit_id')->references('id')
            ->on('fruits')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_fruit');
    }
};
