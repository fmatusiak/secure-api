<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteRoutePoint extends Model
{
    use HasFactory;

    protected $table = 'route_route_points';

    protected $fillable = [
        'route_id',
        'route_point_id',
        'order',
        'arrival_time'
    ];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class, 'route_id');
    }

    public function routePoint(): BelongsTo
    {
        return $this->belongsTo(RoutePoint::class, 'route_point_id');
    }
}
