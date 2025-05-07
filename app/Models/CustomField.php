<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomField extends Model
{
    use SoftDeletes;
    
    protected $table = "custom_field";

    protected $fillable = [
        'name',
        'type'
    ];

    public static function getTypes(){
        return [
            'Text' => 'text',
            'Date' => 'date',
            'Number' => 'number',
            'Email' => 'email'
        ];
    }
}
