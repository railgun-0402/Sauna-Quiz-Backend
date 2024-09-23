<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('comment_id')->comment('コメントID');
            $table->text('content')->comment('設問');
            $table->timestamp('created_at')->useCurrent()->nullable()->comment('作成日時');
            $table->timestamp('updated_at')->useCurrent()->nullable()->comment('更新日時');
            $table->softDeletes()->nullable()->comment('削除日時');
        });

        DB::statement("ALTER TABLE quizzes COMMENT = 'クイズ設問テーブル'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
