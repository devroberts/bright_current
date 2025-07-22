<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class System extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_id',
        'customer_name',
        'customer_type',
        'manufacturer',
        'status',
        'location',
        'latitude',
        'longitude',
        'capacity',
        'install_date',
        'last_seen',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'capacity' => 'float',
        'install_date' => 'datetime',
        'last_seen' => 'datetime',
    ];

    public function productionData()
    {
        return $this->hasMany(ProductionData::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    public function serviceSchedules()
    {
        return $this->hasMany(ServiceSchedule::class);
    }

}
