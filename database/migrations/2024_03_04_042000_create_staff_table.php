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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name', 70);
            $table->string('email', 70);
            $table->string('password', 255);
            $table->string('address', 255);
            $table->string('phone', 30);
            $table->date('birthday');
            $table->integer('role');
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('account_id')->references('id')
            // ->on('account')
            // ->onDelete('cascade')
            // ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
