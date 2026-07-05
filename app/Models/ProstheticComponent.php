<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProstheticComponent extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'prosthetic_components';

    // Define the primary key (since it's not 'id')
    protected $primaryKey = 'compID';

    // Allow mass assignment for the following columns
    protected $fillable = [
        'name',
        'type',
        'size',
        'compatibility',
        'material',
        'weight_min',
        'weight_max',
        'description',
        'is_active',
        'age_min',
        'age_max',
        'klevel_range',
        'bscore_min',
        'bscore_max',
    ];

    // Cast attributes to appropriate types
    protected $casts = [
        'is_active' => 'boolean',
        'weight_min' => 'integer',
        'weight_max' => 'integer',
        'age_min' => 'integer',
        'age_max' => 'integer',
        'bscore_min' => 'integer',
        'bscore_max' => 'integer',
    ];
}