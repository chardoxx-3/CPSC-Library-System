<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\BookModel;
use App\Models\MemberModel;

class Reports extends BaseController
{
    public function index()
    {
        if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');
        
        $type = $this->request->getVar('type');
        $data['report_type'] = $type;
        $data['results'] = [];

        $transModel = new TransactionModel();
        $bookModel = new BookModel();

        if ($type == 'borrowed_books') {
            // Get borrowed books with book details including images
            $data['results'] = $transModel->select('transactions.*, books.title, books.author, books.image, members.full_name')
                                         ->join('books', 'books.id = transactions.book_id')
                                         ->join('members', 'members.id = transactions.member_id')
                                         ->where('transactions.status', 'borrowed')
                                         ->findAll();
        } elseif ($type == 'available_books') {
            $data['results'] = $bookModel->where('quantity >', 0)->findAll();
        } elseif ($type == 'overdue') {
            // Get overdue books with book details including images
            $data['results'] = $transModel->select('transactions.*, books.title, books.author, books.image, members.full_name')
                                         ->join('books', 'books.id = transactions.book_id')
                                         ->join('members', 'members.id = transactions.member_id')
                                         ->where('transactions.status', 'borrowed')
                                         ->where('transactions.due_date <', date('Y-m-d'))
                                         ->findAll();
        }

        return view('reports/index', $data);
    }
    
    // Add this new method for print pages
    public function print($type)
    {
        if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');
        
        $data['report_type'] = $type;
        $data['print_date'] = date('F d, Y');
        $data['library_name'] = 'Digital Library System'; // You can make this dynamic

        $transModel = new TransactionModel();
        $bookModel = new BookModel();

        if ($type == 'borrowed_books') {
            $data['title'] = 'BORROWED BOOKS REPORT';
            $data['results'] = $transModel->select('transactions.*, books.title, books.author, books.image, members.full_name')
                                         ->join('books', 'books.id = transactions.book_id')
                                         ->join('members', 'members.id = transactions.member_id')
                                         ->where('transactions.status', 'borrowed')
                                         ->findAll();
            return view('reports/print_borrowed', $data);
            
        } elseif ($type == 'available_books') {
            $data['title'] = 'AVAILABLE BOOKS INVENTORY';
            $data['results'] = $bookModel->where('quantity >', 0)->findAll();
            return view('reports/print_available', $data);
            
        } elseif ($type == 'overdue') {
            $data['title'] = 'OVERDUE BOOKS REPORT';
            $data['results'] = $transModel->select('transactions.*, books.title, books.author, books.image, members.full_name')
                                         ->join('books', 'books.id = transactions.book_id')
                                         ->join('members', 'members.id = transactions.member_id')
                                         ->where('transactions.status', 'borrowed')
                                         ->where('transactions.due_date <', date('Y-m-d'))
                                         ->findAll();
            return view('reports/print_overdue', $data);
        }
        
        return redirect()->to('/reports');
    }
}