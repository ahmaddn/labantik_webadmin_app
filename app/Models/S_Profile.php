<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class S_Profile extends Model
{
    protected $table = 's_profiles';
    public $incrementing = false; // Karena bukan auto increment
    protected $keyType = 'string'; // UUID adalah string
    protected $fillable = [
        'id',
        's_menu_id',
        'content',
        'created_by',
        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
}
