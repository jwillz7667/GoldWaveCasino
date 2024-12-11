<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'type',
        'description',
        'min_bet',
        'max_bet',
        'image_url',
        'is_active',
        'settings'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'min_bet' => 'decimal:2',
        'max_bet' => 'decimal:2',
        'is_active' => 'boolean',
        'settings' => 'array'
    ];

    /**
     * Get the transactions for the game.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Scope a query to only include active games.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include games of a specific type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if the bet amount is within allowed limits.
     *
     * @param  float  $amount
     * @return bool
     */
    public function isValidBet($amount)
    {
        return $amount >= $this->min_bet && $amount <= $this->max_bet;
    }

    /**
     * Get the game's configuration.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getConfig($key, $default = null)
    {
        return data_get($this->settings, $key, $default);
    }
}
