<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyHead extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'birthdate',
        'mobile_no',
        'address',
        'state',
        'city',
        'pincode',
        'marital_status',
        'wedding_date',
        'photo'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'wedding_date' => 'date',
    ];

    protected $appends = ['photo_url', 'full_name', 'age', 'birthdate_formatted'];

    public function getPhotoUrlAttribute()
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birthdate)->age;
    }

    public function hobbies()
    {
        return $this->hasMany(Hobby::class);
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function getBirthdateFormattedAttribute()
    {
        return Carbon::parse($this->birthdate)->format('d M Y');
    }
}