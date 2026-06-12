<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'user_id',
        'user_name',
        'user_email',
        'plan_id',
        'plan_name',
        'plan_duration',
        'amount',
        'payment_status',
        'payment_method',
        'payment_type',
        'transaction_id',
        'start_date',
        'end_date',
        'renewed_at',
        'cancelled_at',
        'approved_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'renewed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'plan_id');
    }

    public function isActive()
    {
        return $this->payment_status === 'Active' && 
               $this->end_date >= now();
    }

    public function isExpired()
    {
        return $this->payment_status === 'Active' && 
               $this->end_date < now();
    }

    public function scopeActive($query)
    {
        return $query->where('payment_status', 'Active');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'Pending');
    }

    public function scopeExpired($query)
    {
        return $query->where('payment_status', 'Expired');
    }

    public function getFormattedAmountAttribute()
    {
        return '$' . number_format($this->amount, 2);
    }

    public function getDaysRemainingAttribute()
    {
        if ($this->payment_status !== 'Active') {
            return 0;
        }

        $now = now();
        $endDate = \Carbon\Carbon::parse($this->end_date);

        return $now->diffInDays($endDate, false);
    }
}