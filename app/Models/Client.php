<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public $timestamps =  false;
    protected $fillable = [
        'email','join_date'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class,'user_id','id');
    }

}
