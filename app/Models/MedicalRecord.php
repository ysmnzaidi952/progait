<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $table = 'medical_records'; // Optional if your table name is exactly 'medical_records'
    protected $primaryKey = 'medID';
    public $incrementing = true; // (default true, keep if unchanged)
    protected $keyType = 'int';  // (optional, good practice)

    protected $fillable = [
        'patient_id',
        'status',
        'assigned_doctor',
        'amputation_level',
        'amputation_date',
        'weight_kg',
        'height_cm',
        'bmi',
        'blood_pressure',
        'heart_rate',
        'blood_sugar_level',
        'k_level',
        'health_condition',
        'blart_score',
        'mobility_aid_used',
        'rehabilitation_status',
        'treatment_notes',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id', 'patientID');
    }

}
