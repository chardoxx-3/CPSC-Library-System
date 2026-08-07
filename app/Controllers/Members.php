<?php

namespace App\Controllers;

use App\Models\MemberModel;
use App\Models\TransactionModel;
use App\Models\UserModel;

class Members extends BaseController
{
    public function index()
    {
        // Admin: View all members
        if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');

        $model = new MemberModel();
        $data['members'] = $model->findAll();
        
        return view('members/index', $data);
    }

public function profile()
{
    // Member: View own profile
    $memberModel = new MemberModel();
    $userModel = new \App\Models\UserModel(); // Add this
    
    $userId = session()->get('id');
    
    // Get user data
    $data['user'] = $userModel->find($userId); // Add this
    
    // Get member data
    $data['member'] = $memberModel->where('user_id', $userId)->first();
    
    return view('members/profile', $data);
}

    // Add this method to your Members.php controller
public function view($id = null)
{
    // Admin only can view member details
    if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');

    $model = new MemberModel();
    $data['member'] = $model->find($id);
    
    if (!$data['member']) {
        return redirect()->to('/members')->with('error', 'Member not found');
    }
    
    // Get member's transactions
    $transactionModel = new TransactionModel();
    $data['transactions'] = $transactionModel->select('transactions.*, books.title, books.author')
        ->join('books', 'books.id = transactions.book_id')
        ->where('transactions.member_id', $id)
        ->orderBy('transactions.borrow_date', 'DESC')
        ->findAll();
    
    return view('members/view', $data);
}

public function print()
{
    // Admin only can print members list
    if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');

    $model = new MemberModel();
    $data['members'] = $model->findAll();
    
    // Return a view optimized for printing
    return view('members/print_members', $data);
}
}