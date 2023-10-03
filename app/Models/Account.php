<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Account extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define the relationship between the given account and
     * the customer associated with it.
     *
     * @return BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Define the relationship between the given account and
     * all the transactions associated with it.
     *
     * @return BelongsToMany
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class);
    }

    /**
     * Define the relationship between the given account and
     * all the crediting transactions associated with it.
     *
     * @return BelongsToMany
     */
    public function creditTransactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)
            ->where('credit_amount', '>', 0);
    }

    /**
     * Define the relationship between the given account and
     * all the debiting transactions associated with it.
     *
     * @return BelongsToMany
     */
    public function debitTransactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class)
            ->where('debit_amount', '>', 0);
    }
}
