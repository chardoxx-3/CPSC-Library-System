<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\BookModel;
use App\Models\MemberModel;
use App\Models\FineModel;

class Transactions extends BaseController
{
    public function borrow()
    {
        if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');
        
        // Load data for dropdowns
        $bookModel = new BookModel();
        $memberModel = new MemberModel();
        
        $data['books'] = $bookModel->where('quantity >', 0)->findAll();
        $data['members'] = $memberModel->findAll();

        return view('transactions/borrow', $data);
    }

    public function saveBorrow()
    {
        $transModel = new TransactionModel();
        $bookModel = new BookModel();

        $bookId = $this->request->getVar('book_id');
        
        // 1. Create Transaction
        $data = [
            'book_id'     => $bookId,
            'member_id'   => $this->request->getVar('member_id'),
            'borrow_date' => date('Y-m-d'),
            'due_date'    => date('Y-m-d', strtotime('+7 days')), // 7 Day policy
            'status'      => 'borrowed'
        ];
        $transModel->save($data);

        // 2. Decrease Book Quantity
        $book = $bookModel->find($bookId);
        $newQty = $book['quantity'] - 1;
        $bookModel->update($bookId, ['quantity' => $newQty]);

        return redirect()->to('/transactions/history');
    }

// In your Transactions.php controller, update the returnItem() method:

public function returnItem()
{
    if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');
    
    $transModel = new TransactionModel();
    $bookModel = new BookModel();
    
    // Get all active borrows with book details including images
    $data['borrows'] = $transModel->select('transactions.*, books.title, books.image, members.full_name')
                                 ->join('books', 'books.id = transactions.book_id')
                                 ->join('members', 'members.id = transactions.member_id')
                                 ->where('transactions.status', 'borrowed')
                                 ->findAll();
    
    return view('transactions/return', $data);
}

    public function processReturn($id)
    {
        $transModel = new TransactionModel();
        $bookModel = new BookModel();
        $fineModel = new FineModel();

        $transaction = $transModel->find($id);
        $returnDate = date('Y-m-d');

        // 1. Calculate Fines
        $dueDate = $transaction['due_date'];
        $fineAmount = 0;
        $status = 'returned';

        if($returnDate > $dueDate) {
            $diff = strtotime($returnDate) - strtotime($dueDate);
            $daysLate = round($diff / (60 * 60 * 24));
            $fineRate = 10; // 10 PHP per day
            $fineAmount = $daysLate * $fineRate;
            
            // Record Fine
            if($fineAmount > 0){
                $fineModel->save([
                    'transaction_id' => $id,
                    'amount' => $fineAmount,
                    'status' => 'unpaid'
                ]);
            }
        }

        // 2. Update Transaction
        $transModel->update($id, [
            'return_date' => $returnDate,
            'status' => $status
        ]);

        // 3. Increase Book Quantity
        $book = $bookModel->find($transaction['book_id']);
        $bookModel->update($transaction['book_id'], ['quantity' => $book['quantity'] + 1]);

        return redirect()->to('/transactions/history')->with('msg', 'Book returned. Fine: ' . $fineAmount);
    }

    public function history()
    {
        $transModel = new TransactionModel();
        $data['transactions'] = $transModel->orderBy('id', 'DESC')->findAll();
        return view('transactions/history', $data);
    }
}