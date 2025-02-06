<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');                // 標題
            $table->string('slug')->unique();       // URL 友善字串
            $table->text('content');                // 內容
            $table->string('image')->nullable();    // 圖片
            $table->boolean('is_active')->default(true); // 是否啟用
            $table->timestamp('published_at')->nullable(); // 發布時間
            $table->string('meta_title')->nullable();     // SEO 標題
            $table->text('meta_description')->nullable(); // SEO 描述
            $table->string('meta_keywords')->nullable();  // SEO 關鍵字
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('news');
    }
};
