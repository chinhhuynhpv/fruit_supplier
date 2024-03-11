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
        Schema::create('fruits', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('unit_id');
            $table->bigInteger('fruit_category_id')->unsigned();
            $table->string('fruit_name',255);
            $table->double('quantity', 8, 2);
            $table->double('price', 8, 2);
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('unit_id')->references('id')
            // ->on('unit')
            // ->onDelete('cascade')
            // ->onUpdate('cascade');

            $table->foreign('fruit_category_id')->references('id')
            ->on('fruit_category')
            ->onDelete('cascade')
            ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fruits');
    }
};
