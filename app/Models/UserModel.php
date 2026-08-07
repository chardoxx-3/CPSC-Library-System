<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    // Fields that can be inserted or updated via code
    protected $allowedFields = [
        'username', 
        'email', 
        'password', 
        'role' // 'admin' or 'member'
    ];

    // Automatically manage created_at and updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}