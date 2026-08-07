<?php

namespace App\Models;

use CodeIgniter\Model;

class BookModel extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'author',
        'publisher',
        'year',
        'category',
        'isbn',
        'quantity',
        'shelf_location',
        'image', // Added image field
        'status' // e.g., 'available', 'reserved'
    ];

    protected $useTimestamps = true;
}