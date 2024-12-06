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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название поста
            $table->string('image'); // Ссылка на изображение
            $table->string('geo')->nullable(); // Геолокация (например, страна, город)
            $table->unsignedBigInteger('user_id'); // Привязка к пользователю
            $table->boolean('target_blank')->default(false); // Открывать ссылку в новой вкладке
            $table->unsignedBigInteger('clicks')->default(0); // Количество кликов
            $table->unsignedBigInteger('views')->default(0); // Количество просмотров
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
