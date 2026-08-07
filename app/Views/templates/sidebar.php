<?php $role = session()->get('role'); ?>
<?php $uri = service('uri'); ?>

<!-- Mobile Toggle -->
<button class="btn btn-primary d-md-none position-fixed m-3 shadow-lg" style="z-index: 101; border-radius: 50%; width: 50px; height: 50px;" onclick="document.querySelector('.sidebar').classList.toggle('active')">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar">
    <!-- BRAND LOGO AREA -->
    <div class="brand">
        <!-- Image from public/images folder. Adjust 'logo.png' to your actual file name -->
        <img src="/images/logo.png" alt="Logo" class="brand-logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        
        <!-- Fallback Icon if image fails loading -->
        <div style="background: var(--primary); padding: 10px; border-radius: 12px; color: white; display:none;">
            <i class="fas fa-book-reader"></i>
        </div>
        
        <span>CPSC Library</span>
    </div>
    
    <div class="nav flex-column mb-auto">
        <!-- Admin Menu -->
        <?php if($role == 'admin'): ?>
            <div class="sidebar-header">Admin Tools</div>
            
            <a href="<?= site_url('dashboard/admin') ?>" class="nav-link <?= ($uri->getSegment(2) == 'admin') ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            
            <a href="<?= site_url('books') ?>" class="nav-link <?= ($uri->getSegment(1) == 'books') ? 'active' : '' ?>">
                <i class="fas fa-book"></i> Manage Books
            </a>
            
            <a href="<?= site_url('members') ?>" class="nav-link <?= ($uri->getSegment(1) == 'members') ? 'active' : '' ?>">
                <i class="fas fa-users"></i> Member List
            </a>

            <div class="sidebar-header">Circulation</div>
            
            <a href="<?= site_url('transactions/borrow') ?>" class="nav-link">
                <i class="fas fa-hand-holding"></i> Issue Book
            </a>
            
            <a href="<?= site_url('transactions/return') ?>" class="nav-link">
                <i class="fas fa-undo"></i> Return Book
            </a>
                        </a>
                        <a href="<?= site_url('reports') ?>" class="nav-link <?= ($uri->getSegment(1) == 'reports') ? 'active' : '' ?>">
                <i class="fas fa-chart-line me-2"></i> Reports
            </a>
            <a href="<?= site_url('profile') ?>" class="nav-link <?= ($uri->getSegment(1) == 'profile') ? 'active' : '' ?>">
                <i class="fas fa-user-cog"></i> Admin Profile
            </a>
        <?php endif; ?>

        <!-- Member Menu -->
        <?php if($role == 'member'): ?>
            <div class="sidebar-header">Menu</div>

            <a href="<?= site_url('dashboard/member') ?>" class="nav-link <?= ($uri->getSegment(2) == 'member') ? 'active' : '' ?>">
                <i class="fas fa-home"></i> Dashboard
            </a>
            
            <a href="<?= site_url('books') ?>" class="nav-link <?= ($uri->getSegment(1) == 'books') ? 'active' : '' ?>">
                <i class="fas fa-search"></i> Browse Books
            </a>
            
            <a href="<?= site_url('members/profile') ?>" class="nav-link <?= ($uri->getSegment(2) == 'profile') ? 'active' : '' ?>">
                <i class="fas fa-user"></i> My Profile
            </a>
        <?php endif; ?>
    </div>

    <!-- User Profile / Logout Section -->
    <div class="mt-5">
        <div class="p-3 rounded-4 d-flex align-items-center justify-content-between" style="background-color: #F7F7FB;">
            <div class="d-flex align-items-center gap-3">
                <!-- User Avatar -->
                <img src="https://ui-avatars.com/api/?name=<?= session()->get('username') ?>&background=6C5DD3&color=fff" 
                     class="rounded-circle" style="width: 40px; height: 40px;" alt="User">
                
                <div style="line-height: 1.3;">
                    <span class="d-block fw-bold text-dark" style="font-size: 0.9rem;"><?= session()->get('username') ?></span>
                    <span style="font-size: 0.75rem; color: var(--secondary);"><?= ucfirst($role) ?></span>
                </div>
            </div>
            
            <a href="<?= site_url('auth/logout') ?>" class="text-danger p-2" title="Logout" style="transition: 0.2s;">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </div>
</div>