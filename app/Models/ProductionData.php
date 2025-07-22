<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionData extends Model
{
    public function system()
    {
        return $this->belongsTo(System::class);
    }
}
