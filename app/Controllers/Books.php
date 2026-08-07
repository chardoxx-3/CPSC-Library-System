<?php

namespace App\Controllers;

use App\Models\BookModel;

class Books extends BaseController
{
    public function index()
    {
        $model = new BookModel();
        $data['books'] = $model->findAll();
        
        return view('books/index', $data);
    }

    public function add()
    {
        if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');
        return view('books/add');
    }

    public function store()
    {
        $model = new BookModel();
        $imageName = null;

        // Handle image upload
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Create upload directory if it doesn't exist
            $uploadPath = ROOTPATH . 'public/uploads/books/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $imageName = $imageFile->getRandomName();
            
            // Resize and save image
            $imageFile->move($uploadPath, $imageName);
        }

        $data = [
            'title'          => $this->request->getVar('title'),
            'author'         => $this->request->getVar('author'),
            'publisher'      => $this->request->getVar('publisher'),
            'year'           => $this->request->getVar('year'),
            'category'       => $this->request->getVar('category'),
            'isbn'           => $this->request->getVar('isbn'),
            'quantity'       => $this->request->getVar('quantity'),
            'shelf_location' => $this->request->getVar('shelf_location'),
            'image'          => $imageName, // Save image filename
            'status'         => 'available'
        ];

        $model->save($data);
        return redirect()->to('/books');
    }

    public function edit($id = null)
    {
        if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');
        
        $model = new BookModel();
        $data['book'] = $model->find($id);
        
        return view('books/edit', $data);
    }

    public function update()
    {
        $model = new BookModel();
        $id = $this->request->getVar('id');
        
        // Get current book data
        $currentBook = $model->find($id);
        $imageName = $currentBook['image'] ?? null;

        // Check if image should be removed
        if ($this->request->getVar('remove_image') == '1') {
            // Delete old image if exists
            if ($imageName && file_exists(ROOTPATH . 'public/uploads/books/' . $imageName)) {
                unlink(ROOTPATH . 'public/uploads/books/' . $imageName);
            }
            $imageName = null;
        }

        // Handle new image upload
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Delete old image if exists
            if ($imageName && file_exists(ROOTPATH . 'public/uploads/books/' . $imageName)) {
                unlink(ROOTPATH . 'public/uploads/books/' . $imageName);
            }

            // Create upload directory if it doesn't exist
            $uploadPath = ROOTPATH . 'public/uploads/books/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Generate unique filename
            $imageName = $imageFile->getRandomName();
            $imageFile->move($uploadPath, $imageName);
        }

        $data = [
            'title'          => $this->request->getVar('title'),
            'author'         => $this->request->getVar('author'),
            'publisher'      => $this->request->getVar('publisher'),
            'year'           => $this->request->getVar('year'),
            'category'       => $this->request->getVar('category'),
            'isbn'           => $this->request->getVar('isbn'),
            'quantity'       => $this->request->getVar('quantity'),
            'shelf_location' => $this->request->getVar('shelf_location'),
            'image'          => $imageName // Update image filename
        ];

        $model->update($id, $data);
        return redirect()->to('/books');
    }

    public function delete($id = null)
    {
        if(session()->get('role') != 'admin') return redirect()->to('/dashboard/member');
        
        $model = new BookModel();
        $book = $model->find($id);
        
        // Delete associated image if exists
        if (!empty($book['image']) && file_exists(ROOTPATH . 'public/uploads/books/' . $book['image'])) {
            unlink(ROOTPATH . 'public/uploads/books/' . $book['image']);
        }
        
        $model->delete($id);
        
        return redirect()->to('/books');
    }
}