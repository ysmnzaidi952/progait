<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    // Tell Laravel the custom primary key
    protected $primaryKey = 'appID';

    // Optional (but recommended)
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'patientID',
        'appointmentDate',
        'appointmentTime',
        'status',
        'typeAmputee',
        'hospitalRefer',
        'sponsor',
        'nextHospitalAppointment',
        'notes',
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientID', 'patientID');
    }


}
