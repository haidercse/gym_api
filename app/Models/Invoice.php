<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['member_id', 'create_by', 'start_date', 'end_date', 'amount', 'fee_type', 'payment_type'];

    /**
     * Get the user that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'create_by', 'id');
    }
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'member_id');
    }
}
