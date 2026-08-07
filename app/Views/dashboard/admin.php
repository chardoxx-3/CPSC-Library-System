<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1">Admin Dashboard</h2>
                <p class="text-muted mb-0">Overview of library performance and activities.</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="row g-4 mb-5">
            <!-- Card 1: Total Books -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom p-4 h-100 d-flex justify-content-between align-items-center position-relative overflow-hidden">
                    <div class="z-1">
                        <p class="text-muted small text-uppercase fw-bold mb-2">Total Books</p>
                        <h2 class="fw-bold mb-0 text-dark"><?= $total_books ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: #EBE9F6; color: #6C5DD3;">
                        <i class="fas fa-book fa-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Active Borrows -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom p-4 h-100 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-2">Active Issued</p>
                        <h2 class="fw-bold mb-0 text-dark"><?= $borrowed_books ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: #FFF4DE; color: #FFA800;">
                        <i class="fas fa-hand-holding fa-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Card 3: Total Members -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom p-4 h-100 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-2">Members</p>
                        <h2 class="fw-bold mb-0 text-dark"><?= $total_members ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: #E1F1FF; color: #3E97FF;">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                </div>
            </div>

            <!-- Card 4: Overdue -->
            <div class="col-md-6 col-lg-3">
                <div class="card-custom p-4 h-100 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted small text-uppercase fw-bold mb-2">Overdue</p>
                        <h2 class="fw-bold mb-0 text-danger"><?= $overdue_count ?></h2>
                    </div>
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 60px; height: 60px; background: #FFE2E5; color: #F64E60;">
                        <i class="fas fa-exclamation-triangle fa-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lower Section: Actions & Status -->
        <div class="row g-4">
            
            <!-- Quick Actions -->
            <div class="col-lg-7">
                <div class="card-custom p-4 h-100">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h5 class="fw-bold mb-0">Quick Actions</h5>
                        <i class="fas fa-bolt text-warning"></i>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <!-- Action Item 1 -->
                        <a href="<?= site_url('transactions/borrow') ?>" class="d-flex align-items-center p-3 rounded-3 text-decoration-none bg-light hover-shadow transition-all">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-dark fw-bold mb-0">Issue New Book</h6>
                                <small class="text-muted">Register a new borrowing transaction</small>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </a>

                        <!-- Action Item 2 -->
                        <a href="<?= site_url('transactions/return') ?>" class="d-flex align-items-center p-3 rounded-3 text-decoration-none bg-light hover-shadow transition-all">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-undo"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-dark fw-bold mb-0">Process Return</h6>
                                <small class="text-muted">Accept returned books from members</small>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </a>

                        <!-- Action Item 3 -->
                        <a href="<?= site_url('books/add') ?>" class="d-flex align-items-center p-3 rounded-3 text-decoration-none bg-light hover-shadow transition-all">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="text-dark fw-bold mb-0">Add Inventory</h6>
                                <small class="text-muted">Register new books to the system</small>
                            </div>
                            <i class="fas fa-chevron-right text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="col-lg-5">
                <div class="card-custom p-4 h-100 text-white" style="background: linear-gradient(145deg, #2c3e50, #4ca1af);">
                    <h5 class="fw-bold mb-4">System Status</h5>
                    
                    <div class="mb-4">
                        <small class="opacity-75 text-uppercase fw-bold" style="font-size: 0.7rem;">Database Connection</small>
                        <div class="d-flex align-items-center mt-1">
                            <div class="spinner-grow spinner-grow-sm text-success me-2" role="status"></div>
                            <span class="fw-bold fs-5">Online</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <small class="opacity-75 text-uppercase fw-bold" style="font-size: 0.7rem;">Last Backup</small>
                        <div class="d-flex align-items-center mt-1">
                            <i class="fas fa-clock me-2 opacity-75"></i>
                            <span class="fs-5">Today, 08:00 AM</span>
                        </div>
                    </div>

                    <div class="mt-auto p-3 rounded-3" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(5px);">
                        <div class="d-flex gap-3">
                            <i class="fas fa-info-circle fa-lg mt-1 text-info"></i>
                            <div style="line-height: 1.4;">
                                <span class="fw-bold d-block">Reminder</span>
                                <small class="opacity-75">Ensure all daily returns are processed before 5 PM to avoid system calculation errors.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Inline helper for specific hover effect on this page */
    .hover-shadow:hover {
        background: white !important;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transform: translateX(5px);
    }
    .transition-all {
        transition: all 0.3s ease;
    }
</style>

<?= view('templates/footer') ?>