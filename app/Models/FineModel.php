<?php

namespace App\Models;

use CodeIgniter\Model;

class FineModel extends Model
{
    protected $table = 'fines';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'transaction_id',
        'amount',
        'status' // 'paid', 'unpaid'
    ];

    protected $useTimestamps = true;
}