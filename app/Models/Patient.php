<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Patient extends Authenticatable
{
    use HasFactory;

    protected $table = 'patient';

    protected $primaryKey = 'patientID';
    public $incrementing = false; // if your patientID is not auto-increment
    protected $keyType = 'string'; // if patientID is string

    protected $fillable = [
        'patientName',
        'patientIC',
        'patientEmail',
        'patientTel',
        'patientPass',
        'dateOfBirth',
        'maritalStatus',
        'address',
        'race',
        'gender',
    ];

    protected $hidden = [
        'patientPass',
    ];

    public $timestamps = true;

    public function setPatientPassAttribute($patientPass)
    {
        $this->attributes['patientPass'] = Hash::make($patientPass);
    }

    public function getAuthIdentifierName()
    {
        return 'patientIC';
    }

    public function getAuthIdentifier()
    {
        return $this->patientIC;
    }

    public function getAuthPassword()
    {
        return $this->patientPass;
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dateOfBirth)->age;  // Calculate age from the 'dateOfBirth' field
    }
}
