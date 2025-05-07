<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactCustomField extends Model
{
    use SoftDeletes;

    protected $table = "contact_custom_field";

    protected $fillable = [
        "iContactId",
        "iCustomFieldId",
        "data",
        "isMerged"
    ];
}
