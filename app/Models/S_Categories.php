<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class S_Categories extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 's_categories';

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
        'name',
        'is_active',
    ];
}
