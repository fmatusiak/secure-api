<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoutePoint extends Model
{
    use HasFactory;

    protected mixed $name;
    protected float $latitude;
    protected float $longitude;

    protected $fillable = [
        'name',
        'latitude',
        'longitude'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public function getName(): mixed
    {
        return $this->name;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function isAssignedToUser(User $user): bool
    {
        return $this->routes()->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->exists();
    }

    public function routes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'route_route_points');
    }
}
