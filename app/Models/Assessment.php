<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $primaryKey = 'formID';

    protected $fillable = [
        'patientID',               // ✅ Now matches DB and relationship
        'race',
        'gender',
        'address',
        'sponsor',
        'hospital',
        'weight',
        'footSize',
        'linerSize',
        'amputationDate',
        'prosthesisNo',
        'patientTel',
        'patientTel2',
        'reasonAmputation',
        'patientAssessment',
        'dialysisDay',
        'componentSuggestions',
        'attendedBy',
        'prescribedBy',
        'receiveDate',
    ];

    // ✅ Correct relationship using patientID
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientID', 'patientID');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'attendedBy', 'staffName');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'prescribedBy', 'docName');
    }
}
