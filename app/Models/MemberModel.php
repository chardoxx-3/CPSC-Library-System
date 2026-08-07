<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
    protected $table = 'members';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', // Foreign Key linking to users table
        'full_name',
        'address',
        'contact_number'
    ];

    protected $useTimestamps = true;
}