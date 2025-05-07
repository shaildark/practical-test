<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactAdditionalField extends Model
{
    protected $table = "contact_additional_field";

    protected $fillable = [
        "iContactId",
        "iChildContactId",
        "type",
        "value",
    ];
}
