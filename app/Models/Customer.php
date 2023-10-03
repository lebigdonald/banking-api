<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Customer extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Define the relationship between the given customer and
     * all the accounts associated with it.
     *
     * @return BelongsToMany
     */
    public function accounts(): BelongsToMany
    {
        return $this->belongsToMany(Account::class);
    }

    /**
     * Define the relationship between the given customer and
     * all the transactions associated with it.
     *
     * @return BelongsToMany
     */
    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class);
    }

}
