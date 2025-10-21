<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class S_News extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 's_news';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'category_id',
        'is_published',
    ];
}
