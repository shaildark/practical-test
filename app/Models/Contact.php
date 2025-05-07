<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\CustomField;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = "contact";

    protected $fillable = [
        'iUserId',
        'name',
        'email',
        'phone',
        'gender',
        'profile_image',
        'additional_file'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, "iUserId", "id");
    }

    public function customdata()
    {
        return $this->belongsToMany(CustomField::class, "contact_custom_field", 'iContactId', 'iCustomFieldId')->withPivot("data", "isMerged");
    }

    public function additionaldata()
    {
        return $this->hasMany(ContactAdditionalField::class, "iContactId", "id");
    }
}
