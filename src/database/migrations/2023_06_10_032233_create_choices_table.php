<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quiz_id')->comment('クイズID');
            $table->unsignedInteger('category_id')->comment('カテゴリーID');
            $table->text('content')->comment('回答選択肢');
            $table->boolean('is_answer')->comment('正答フラグ');
            $table->timestamp('created_at')->useCurrent()->nullable()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->nullable()->comment('更新日時');
            $table->softDeletes()->nullable()->comment('削除日時');
        });

        DB::statement("ALTER TABLE choices COMMENT = '回答選択肢テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('choices');
    }
}
