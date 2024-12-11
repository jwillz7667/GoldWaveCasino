<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'game_id',
        'type',
        'amount',
        'balance',
        'details',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'details' => 'array'
    ];

    /**
     * Transaction types.
     */
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAW = 'withdraw';
    const TYPE_SLOT_SPIN = 'slot_spin';
    const TYPE_SLOT_WIN = 'slot_win';
    const TYPE_ARCADE_START = 'arcade_start';
    const TYPE_ARCADE_WIN = 'arcade_win';
    const TYPE_BONUS = 'bonus';

    /**
     * Transaction statuses.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the game associated with the transaction.
     */
    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Scope a query to only include transactions of a specific type.
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
     * Scope a query to only include transactions with a specific status.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include deposits.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDeposits($query)
    {
        return $query->where('type', self::TYPE_DEPOSIT);
    }

    /**
     * Scope a query to only include withdrawals.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithdrawals($query)
    {
        return $query->where('type', self::TYPE_WITHDRAW);
    }

    /**
     * Scope a query to only include game transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGameTransactions($query)
    {
        return $query->whereIn('type', [
            self::TYPE_SLOT_SPIN,
            self::TYPE_SLOT_WIN,
            self::TYPE_ARCADE_START,
            self::TYPE_ARCADE_WIN
        ]);
    }

    /**
     * Get transaction detail.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function getDetail($key, $default = null)
    {
        return data_get($this->details, $key, $default);
    }

    /**
     * Check if the transaction is completed.
     *
     * @return bool
     */
    public function isCompleted()
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Check if the transaction is pending.
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if the transaction is failed.
     *
     * @return bool
     */
    public function isFailed()
    {
        return $this->status === self::STATUS_FAILED;
    }

    /**
     * Check if the transaction is cancelled.
     *
     * @return bool
     */
    public function isCancelled()
    {
        return $this->status === self::STATUS_CANCELLED;
    }
}
