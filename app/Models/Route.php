<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Route extends Model
{
    use HasFactory;

    protected string $name;

    protected $fillable = [
        'name'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function routePoints(): BelongsToMany
    {
        return $this
            ->belongsToMany(RoutePoint::class, 'route_route_points')
            ->withPivot('order', 'arrival_time');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'route_users');
    }
}
