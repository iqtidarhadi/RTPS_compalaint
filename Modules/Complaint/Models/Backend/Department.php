<?php

namespace Modules\Complaint\Models\Backend;

use Modules\Complaint\Models\Complaint;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Complaint\Models\Complaint as ModelsComplaint;

class Department extends Model
{

    use SoftDeletes;


    protected $fillable = [

        'name',
        'status'

    ];


    protected $casts = [

        'status' => 'string'

    ];


    /*
    |--------------------------------------------------------------------------
    | Relationship (future department users)
    |--------------------------------------------------------------------------
    */

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function complaints()
        {
            return $this->hasMany(Complaint::class);
        }

         public function getComplaintStatistics()
    {
        return [
            'total' => $this->complaints()->count(),
            'pending' => $this->complaints()->where('status', 'pending')->count(),
            'in_progress' => $this->complaints()->where('status', 'in_progress')->count(),
            'resolved' => $this->complaints()->where('status', 'resolved')->count(),
            'rejected' => $this->complaints()->where('status', 'rejected')->count(),
        ];
    }
}