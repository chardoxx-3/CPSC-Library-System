<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MemberModel;
use CodeIgniter\Controller;

class ProfileController extends Controller
{
    protected $userModel;
    protected $memberModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->memberModel = new MemberModel();
        helper(['form', 'url', 'session']);
    }

    /**
     * Show profile page
     */
public function index()
{
    // Check if user is logged in
    if (!session()->get('isLoggedIn')) {
        return redirect()->to('/auth');
    }

    $userId = session()->get('id');
    $role = session()->get('role');

    $data = [
        'title' => 'My Profile',
        'user' => $this->userModel->find($userId),
    ];

    // If user is a member, get member details
    if ($role === 'member') {
        $memberData = $this->memberModel->where('user_id', $userId)->first();
        $data['member'] = $memberData;
    }

    // For both admin and member, use the same profile view
    return view('profile/index', $data); // Make sure this matches your folder structure
}

    /**
     * Update personal information
     */
    public function updatePersonal()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $userId = session()->get('id');
        $role = session()->get('role');

        $validation = \Config\Services::validation();
        
        // Validation rules
        $rules = [
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
        ];

        // If it's a member, add member-specific fields
        if ($role === 'member') {
            $memberRules = [
                'full_name' => 'required|min_length[3]|max_length[100]',
                'address' => 'permit_empty|max_length[255]',
                'contact_number' => 'permit_empty|max_length[20]'
            ];
            $rules = array_merge($rules, $memberRules);
        }

        if ($this->validate($rules)) {
            // Update user table
            $userData = [
                'username' => $this->request->getPost('username'),
                'email' => $this->request->getPost('email'),
            ];

            $this->userModel->update($userId, $userData);

            // Update member table if user is a member
            if ($role === 'member') {
                $memberData = [
                    'full_name' => $this->request->getPost('full_name'),
                    'address' => $this->request->getPost('address'),
                    'contact_number' => $this->request->getPost('contact_number')
                ];

                // Check if member record exists
                $memberRecord = $this->memberModel->where('user_id', $userId)->first();
                if ($memberRecord) {
                    $this->memberModel->update($memberRecord['id'], $memberData);
                } else {
                    $memberData['user_id'] = $userId;
                    $this->memberModel->insert($memberData);
                }
            }

            // Update session data
            session()->set([
                'username' => $userData['username'],
                'email' => $userData['email']
            ]);

            session()->setFlashdata('success', 'Personal information updated successfully!');
            return redirect()->to('/profile');
        } else {
            $data = [
                'title' => 'Edit Profile',
                'user' => $this->userModel->find($userId),
                'validation' => $validation
            ];

            if ($role === 'member') {
                $memberData = $this->memberModel->where('user_id', $userId)->first();
                $data['member'] = $memberData;
            }

            return view('profile/index', $data);
        }
    }

    /**
     * Change password
     */
    public function changePassword()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $userId = session()->get('id');

        $validation = \Config\Services::validation();
$validation->setRules([
    'current_password' => 'required',
    'new_password' => 'required|min_length[8]',
    'confirm_password' => 'required|matches[new_password]'
], [
    'current_password' => [
        'required' => 'Current password is required'
    ],
    'new_password' => [
        'required' => 'New password is required',
        'min_length' => 'Password must be at least 8 characters long'
    ],
    'confirm_password' => [
        'required' => 'Please confirm your password',
        'matches' => 'Passwords do not match'
    ]
]);

        if ($this->validate($validation->getRules())) {
            $currentPassword = $this->request->getPost('current_password');
            $newPassword = $this->request->getPost('new_password');

            // Get current user data
            $user = $this->userModel->find($userId);

            // Verify current password
            if (password_verify($currentPassword, $user['password'])) {
                // Hash new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Update password
                $this->userModel->update($userId, ['password' => $hashedPassword]);
                
                session()->setFlashdata('success', 'Password changed successfully!');
                return redirect()->to('/profile');
            } else {
                session()->setFlashdata('error', 'Current password is incorrect');
                return redirect()->to('/profile');
            }
        } else {
            $data = [
                'title' => 'My Profile',
                'user' => $this->userModel->find($userId),
                'validation' => $validation
            ];

            // Get member data if exists
            if (session()->get('role') === 'member') {
                $memberData = $this->memberModel->where('user_id', $userId)->first();
                $data['member'] = $memberData;
            }

            return view('profile/index', $data);
        }
    }

    /**
     * Show edit form
     */
    public function edit()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth');
        }

        $userId = session()->get('id');
        $role = session()->get('role');

        $data = [
            'title' => 'Edit Profile',
            'user' => $this->userModel->find($userId),
        ];

        if ($role === 'member') {
            $memberData = $this->memberModel->where('user_id', $userId)->first();
            $data['member'] = $memberData;
        }

        return view('profile/edit', $data);
    }
}