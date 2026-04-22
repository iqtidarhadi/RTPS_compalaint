<?php

namespace Modules\Complaint\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComplaintHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'complaint_id',
        'action_by',
        'role',
        'decision',
        'remarks',
        'penalty_amount',
    ];

    protected $casts = [
        'penalty_amount' => 'decimal:2',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class);
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
