<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\TransactionModel;
use App\Models\MemberModel;

class Dashboard extends BaseController
{
    public function admin()
    {
        if(session()->get('role') != 'admin') return redirect()->to('/auth');

        $bookModel = new BookModel();
        $transModel = new TransactionModel();
        $memberModel = new MemberModel();

        $data = [
            'total_books' => $bookModel->countAll(),
            'borrowed_books' => $transModel->where('status', 'borrowed')->countAllResults(),
            'total_members' => $memberModel->countAll(),
            'overdue_count' => $transModel->where('status', 'overdue')->countAllResults()
        ];

        return view('dashboard/admin', $data);
    }

// In your Dashboard.php controller, update the member() method:

public function member()
{
    if(session()->get('role') != 'member') return redirect()->to('/auth');

    $transModel = new TransactionModel();
    $userId = session()->get('id');

    // Get member ID from user_id
    $memberModel = new MemberModel();
    $member = $memberModel->where('user_id', $userId)->first();
    
    if (!$member) {
        return redirect()->to('/auth');
    }

    // Get active borrows with book details including images
    $data = [
        'my_borrows' => $transModel->select('transactions.*, books.title, books.image')
                                   ->join('books', 'books.id = transactions.book_id')
                                   ->where('transactions.member_id', $member['id'])
                                   ->where('transactions.status', 'borrowed')
                                   ->findAll(),
        'history_count' => $transModel->where('member_id', $member['id'])->countAllResults()
    ];

    return view('dashboard/member', $data);
}
}