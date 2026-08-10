<?php
// app/Models/FinancialRecord.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'livestock_id',
        'type',
        'category',
        'sub_category',
        'description',
        'amount',
        'transaction_date',
        'payment_method',
        'reference_number',
        'notes',
        'attachment',
        'status'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livestock()
    {
        return $this->belongsTo(Livestock::class);
    }

    // Scopes
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2) . ' MMK';
    }
}
