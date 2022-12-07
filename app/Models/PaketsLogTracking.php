<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketsLogTracking extends Model
{
    use HasFactory;

    function IdexpressStatus(){
        return $this->belongsTo(IdexpressStatus::class,'operationType','operationType');
    }
}
