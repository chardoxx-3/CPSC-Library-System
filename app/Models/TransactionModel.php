<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'book_id',
        'member_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status' // 'borrowed', 'returned', 'overdue'
    ];

    protected $useTimestamps = true;

    // Helper function to join tables (useful for displaying names instead of IDs)
    public function getDetails()
    {
        return $this->select('transactions.*, books.title, members.full_name')
                    ->join('books', 'books.id = transactions.book_id')
                    ->join('members', 'members.id = transactions.member_id')
                    ->findAll();
    }
}