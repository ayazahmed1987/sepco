<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenderPerson extends Model
{
    use SoftDeletes;
    protected $table = 'tender_persons';
    protected $fillable = [
        'name','email','phone'
    ];
}
