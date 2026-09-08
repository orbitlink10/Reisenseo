<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $guarded = [];

    public function client(){

        return $this->hasMany(Client::class);

    }

   
}
