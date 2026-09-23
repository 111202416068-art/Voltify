<?php

namespace App\Models;

use CodeIgniter\Model;

class DeviceModel extends Model
{
    protected $table            = 'devices';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'name', 'watt', 'daily_hours', 'is_turned_on'];
    protected $useTimestamps    = false;
}