<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class Staff extends Authenticatable
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'staffID',
        'staffName',
        'staffIC',
        'staffEmail',
        'staffPass',
        'staffTel',
        'staffRole',
        'status',
        'race',
        'gender',
        'address',
        'dateOfBirth',
        'maritalStatus',
        'dateOfJoining'
    ];

    protected $hidden = ['staffPass'];

    public $timestamps = true;

    protected $primaryKey = 'staffID';

    protected $keyType = 'string';

    public $incrementing = false;

    public function setStaffPassAttribute($staffPass)
    {
        $this->attributes['staffPass'] = Hash::make($staffPass);
    }

    public function getAuthIdentifierName()
    {
        return 'staffIC';
    }

    // Laravel uses this to retrieve the identifier's value
    public function getAuthIdentifier()
    {
        return $this->staffIC;
    }

    // Laravel uses this to retrieve the hashed password
    public function getAuthPassword()
    {
        return $this->staffPass;
    }
}


