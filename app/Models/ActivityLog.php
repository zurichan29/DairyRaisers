<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'user_id', 'activity_type', 'description', 'ip_address'];
    protected $table = 'activity_log';
}
