<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMerge extends Model
{
    protected $table = "contact_merge";

    protected $fillable = [
        "iMasterContactId",
        "iChildContactId",
    ];
}
