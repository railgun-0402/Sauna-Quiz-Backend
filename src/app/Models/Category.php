<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * カテゴリーデータ全取得
     *
     * @return \App\Models\Category[]
     */
    public static function getCategoryAll()
    {
        return Category::all();
    }
}