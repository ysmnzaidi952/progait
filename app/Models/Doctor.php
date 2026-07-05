<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Doctor extends Authenticatable
{
    use HasFactory;

    protected $table = 'doctors';
    protected $primaryKey = 'docID';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'docID',
        'docIC',
        'docName',
        'docEmail',
        'docPass',
        'docTel',
        'status',
        'gender',
        'dateOfBirth',
        'maritalStatus',
        'address',
        'race',
    ];

    protected $hidden = ['docPass'];

    // Mutator: Hash password before saving
    public function setDocPassAttribute($docPass)
    {
        if (!empty($docPass)) {
            $this->attributes['docPass'] = Hash::make($docPass);
        }
    }

    // For Laravel Authentication
    public function getAuthIdentifierName()
    {
        return 'docIC';
    }

    public function getAuthIdentifier()
    {
        return $this->docIC;
    }

    public function getAuthPassword()
    {
        return $this->docPass;
    }
}
