<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $data = $model->where('username', $username)->first();
        
        if ($data) {
            $pass = $data['password'];
            // Verify hashed password
            if (password_verify($password, $pass)) {
                $ses_data = [
                    'id'       => $data['id'],
                    'username' => $data['username'],
                    'role'     => $data['role'],
                    'isLoggedIn' => TRUE
                ];
                $session->set($ses_data);
                
                // Redirect based on role
                if($data['role'] == 'admin'){
                    return redirect()->to('/dashboard/admin');
                } else {
                    return redirect()->to('/dashboard/member');
                }
            } else {
                $session->setFlashdata('msg', 'Wrong Password');
                return redirect()->to('/auth');
            }
        } else {
            $session->setFlashdata('msg', 'Username not found');
            return redirect()->to('/auth');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function store()
    {
        // Validation would go here
        $userModel = new UserModel();
        $memberModel = new MemberModel();

        // 1. Create User Account
        $userData = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role'     => 'member' // Default registration is member
        ];
        
        $userModel->save($userData);
        $userId = $userModel->getInsertID();

        // 2. Create Member Details
        $memberData = [
            'user_id'        => $userId,
            'full_name'      => $this->request->getVar('full_name'),
            'address'        => $this->request->getVar('address'),
            'contact_number' => $this->request->getVar('contact_number')
        ];
        $memberModel->save($memberData);

        return redirect()->to('/auth')->with('msg', 'Registration successful! Please login.');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/auth');
    }
}