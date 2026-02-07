<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessages extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'message',
        'file',
    ];
}
