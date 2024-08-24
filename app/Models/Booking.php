<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'phone',
        'store_id',
        'service_id',
        'booking_date',
        'booking_time',
        'service_price',
        'booking_fee',
        'tax',
        'total',
        'status',
        'payment_proof',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'store_id' => 'integer',
        'service_id' => 'integer',
        'booking_date' => 'date',
        'service_price' => 'integer',
        'booking_fee' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
