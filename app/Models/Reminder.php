<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory;

    protected $table = 'reminders'; // Optional if your table name matches
    protected $primaryKey = 'remID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'patientID',
        'firstDate',
        'firstStatus',
        'secondDate',
        'secondStatus',
        'thirdDate',
        'thirdStatus'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientID', 'patientID');
    }
}
