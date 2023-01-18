<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id','name','gender','mobile_number','blood','address','image','start_date','end_date','lock','create_by','card_no','status'     
    ];
}
