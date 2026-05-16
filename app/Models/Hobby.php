<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hobby extends Model
{   
    use SoftDeletes;

    protected $fillable = [
        'family_head_id',
        'hobby_name',
    ];

    public function familyHead()
    {
        return $this->belongsTo(FamilyHead::class);
    }
}
