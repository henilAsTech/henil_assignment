<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'family_head_id',
        'name',
        'birthdate',
        'marital_status',
        'wedding_date',
        'education',
        'photo'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'wedding_date' => 'date',
    ];

    protected $appends = ['photo_url', 'birthdate_formatted'];

    public function familyHead()
    {
        return $this->belongsTo(FamilyHead::class);
    }

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getBirthdateFormattedAttribute()
    {
        return Carbon::parse($this->birthdate)->format('d M Y');
    }
}
