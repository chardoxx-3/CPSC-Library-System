<?= view('templates/header') ?>

<style>
    /* Scoped CSS for Profile Dashboard */
    :root {
        --primary-gradient: linear-gradient(135deg, #6C5DD3 0%, #A697FF 100%);
        --glass-bg: #ffffff;
        --border-color: #f1f1f1;
    }

    /* Force the main content to fill viewport without window scroll */
    .main-content {
        height: 100vh;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        background-color: #F7F7FA;
    }

    .profile-container {
        flex: 1;
        padding: 1.5rem;
        overflow: hidden; /* Prevent outer scroll */
    }

    /* Cards */
    .card-dashboard {
        background: var(--glass-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card-header-custom {
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        background: transparent;
    }

    .card-body-scroll {
        flex: 1;
        overflow-y: auto; /* Internal scroll only if needed */
        padding: 1.25rem;
        scrollbar-width: thin;
        scrollbar-color: #ccc transparent;
    }

    .card-body-scroll::-webkit-scrollbar {
        width: 6px;
    }
    .card-body-scroll::-webkit-scrollbar-thumb {
        background-color: #ccc;
        border-radius: 20px;
    }

    /* Form Tweaks for Compactness */
    .form-label {
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 0.3rem;
    }
    
    .form-control {
        font-size: 0.9rem;
        padding: 0.6rem 0.8rem;
    }
    
    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(108, 93, 211, 0.1);
        border-color: #6C5DD3;
    }

    .profile-gradient-bg {
        background: var(--primary-gradient);
        height: 80px;
        border-radius: 16px 16px 0 0;
    }
    
    .avatar-wrapper {
        margin-top: -40px;
        display: inline-block;
        padding: 4px;
        background: #fff;
        border-radius: 50%;
    }
</style>

<div class="d-flex h-100">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content Wrapper -->
    <div class="main-content w-100">
        
        <!-- Top Compact Header (Optional, adjusts based on your template) -->
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-white border-bottom">
            <h5 class="fw-bold mb-0 text-dark">Profile Settings</h5>
            
            <!-- Flash Messages (Inline to save space) -->
            <div class="flex-grow-1 px-4">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success py-1 px-3 mb-0 border-0 d-inline-flex align-items-center small shadow-sm">
                        <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close btn-close-white ms-2 small" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger py-1 px-3 mb-0 border-0 d-inline-flex align-items-center small shadow-sm">
                        <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="text-muted small">
                Current Time: <?= date('M d, Y') ?>
            </div>
        </div>

        <!-- 3-Column Dashboard Grid -->
        <div class="profile-container">
            <div class="row h-100 g-3">
                
                <!-- COL 1: Identity & Stats (Fixed Height, non-scrolling usually) -->
                <div class="col-lg-3 h-100">
                    <div class="card-dashboard">
                        <div class="profile-gradient-bg"></div>
                        <div class="text-center px-4 pb-4">
                            <div class="avatar-wrapper shadow-sm">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold display-5" 
                                     style="width: 80px; height: 80px; background: #FF9F43;">
                                    <?= strtoupper(substr($user['username'] ?? 'U', 0, 1)) ?>
                                </div>
                            </div>
                            <h5 class="fw-bold mt-2 mb-0"><?= esc($member['full_name'] ?? $user['username']) ?></h5>
                            <span class="badge bg-primary bg-opacity-10 text-primary mb-3 mt-1">
                                <?= ucfirst(session()->get('role')) ?>
                            </span>

                            <div class="d-flex flex-column gap-2 text-start mt-2">
                                <div class="p-3 rounded-3 bg-light">
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Email</small>
                                    <div class="text-dark fw-medium text-truncate"><?= esc($user['email']) ?></div>
                                </div>
                                
                                <div class="p-3 rounded-3 bg-light">
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Joined Date</small>
                                    <div class="text-dark fw-medium"><?= date('M j, Y', strtotime($user['created_at'])) ?></div>
                                </div>

                                <div class="p-3 rounded-3 bg-light">
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Last Update</small>
                                    <div class="text-dark fw-medium"><?= date('M j, Y', strtotime($user['updated_at'])) ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- COL 2: Edit Profile (The Main Workspace) -->
                <div class="col-lg-6 h-100">
                    <div class="card-dashboard">
                        <div class="card-header-custom d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-3 text-primary me-3">
                                <i class="fas fa-user-edit"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Personal Details</h6>
                        </div>
                        
                        <div class="card-body-scroll">
                            <form action="<?= site_url('profile/updatePersonal') ?>" method="POST">
                                <?= csrf_field() ?>
                                
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold">Username</label>
                                        <input type="text" class="form-control bg-light border-0" name="username" 
                                               value="<?= old('username', $user['username'] ?? '') ?>" required>
                                        <?php if (isset($validation) && $validation->hasError('username')): ?>
                                            <div class="text-danger small mt-1"><?= $validation->getError('username') ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label text-muted fw-bold">Email Address</label>
                                        <input type="email" class="form-control bg-light border-0" name="email" 
                                               value="<?= old('email', $user['email'] ?? '') ?>" required>
                                        <?php if (isset($validation) && $validation->hasError('email')): ?>
                                            <div class="text-danger small mt-1"><?= $validation->getError('email') ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <?php if (session()->get('role') === 'member' && isset($member)): ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="text-uppercase text-muted fw-bold small flex-shrink-0">Member Information</span>
                                        <div class="border-bottom flex-grow-1 ms-3"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label text-muted fw-bold">Full Name</label>
                                        <input type="text" class="form-control bg-light border-0" name="full_name" 
                                               value="<?= old('full_name', $member['full_name'] ?? '') ?>" required>
                                        <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                                            <div class="text-danger small mt-1"><?= $validation->getError('full_name') ?></div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold">Contact Number</label>
                                            <input type="text" class="form-control bg-light border-0" name="contact_number" 
                                                   value="<?= old('contact_number', $member['contact_number'] ?? '') ?>">
                                            <?php if (isset($validation) && $validation->hasError('contact_number')): ?>
                                                <div class="text-danger small mt-1"><?= $validation->getError('contact_number') ?></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label text-muted fw-bold">Role</label>
                                            <input type="text" class="form-control bg-white border" value="Library Member" disabled readonly>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label text-muted fw-bold">Address</label>
                                        <textarea class="form-control bg-light border-0" name="address" rows="3" style="resize: none;"><?= old('address', $member['address'] ?? '') ?></textarea>
                                        <?php if (isset($validation) && $validation->hasError('address')): ?>
                                            <div class="text-danger small mt-1"><?= $validation->getError('address') ?></div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary px-4 shadow-sm">
                                        Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- COL 3: Security (Compact) -->
                <div class="col-lg-3 h-100">
                    <div class="card-dashboard">
                        <div class="card-header-custom d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-3 text-warning me-3">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Security</h6>
                        </div>

                        <div class="card-body-scroll d-flex flex-column justify-content-between">
                            <form action="<?= site_url('profile/changePassword') ?>" method="POST">
                                <?= csrf_field() ?>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted fw-bold">Current Password</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" class="form-control border-start-0" name="current_password" required>
                                    </div>
                                    <?php if (isset($validation) && $validation->hasError('current_password')): ?>
                                        <div class="text-danger small mt-1"><?= $validation->getError('current_password') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label text-muted fw-bold">New Password</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-key text-muted"></i></span>
                                        <input type="password" class="form-control border-start-0" name="new_password" required>
                                    </div>
                                    <small class="text-muted d-block mt-1" style="font-size: 0.7rem; line-height: 1.2;">Min 8 chars, mixed case & symbols.</small>
                                    <?php if (isset($validation) && $validation->hasError('new_password')): ?>
                                        <div class="text-danger small mt-1"><?= $validation->getError('new_password') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label text-muted fw-bold">Confirm</label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-check-double text-muted"></i></span>
                                        <input type="password" class="form-control border-start-0" name="confirm_password" required>
                                    </div>
                                    <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                                        <div class="text-danger small mt-1"><?= $validation->getError('confirm_password') ?></div>
                                    <?php endif; ?>
                                </div>

                                <button type="submit" class="btn btn-warning w-100 text-dark fw-bold shadow-sm">
                                    Update Password
                                </button>
                            </form>

                            <!-- Mini Security Tip at bottom -->
                            <div class="mt-4 p-3 bg-opacity-10 bg-info rounded-3 text-info small border border-info border-opacity-25">
                                <i class="fas fa-info-circle me-1"></i> 
                                Keep your password secure. We recommend changing it every 3 months.
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>