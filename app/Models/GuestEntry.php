<?php

namespace App\Models;
use \Illuminate\Database\Eloquent\Model;
class GuestEntry extends Model
{
    protected  $table="user";
    protected  $fillable=["id","name","email","password"];
}