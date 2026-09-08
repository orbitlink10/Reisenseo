<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    public function scopeDelayed($query, $cutoffDate = null)
    {
        if ($cutoffDate === null) {
            // Default cutoff date (modify this as needed)
            $cutoffDate = Carbon::today()->subDays(7);
        }

        return $query->where('created_at', '<', $cutoffDate);
    }
   
}
