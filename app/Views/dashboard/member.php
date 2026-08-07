<?= view('templates/header') ?>

<!-- Flex container to hold sidebar and main content -->
<div class="d-flex">
    
    <?= view('templates/sidebar') ?>

    <div class="main-content w-100">
        <!-- Top Header (Search & Notifications) -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-none d-md-block">
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light rounded-circle shadow-sm text-primary" style="width: 45px; height: 45px;">
                    <i class="fas fa-bell"></i>
                </button>
                <div class="text-end d-none d-sm-block">
                    <h6 class="mb-0 fw-bold"><?= session()->get('username') ?></h6>
                    <small class="text-muted">Member</small>
                </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="hero-banner d-flex align-items-center justify-content-between">
            <div>
                <h2 class="fw-bold mb-2">Hi, <?= session()->get('username') ?>!</h2>
                <p class="mb-4 opacity-75" style="max-width: 500px;">The library serves as a welcoming home for knowledge seekers. Check your borrowed books and explore new ones.</p>
                <a href="<?= site_url('books') ?>" class="btn btn-light text-primary fw-bold px-4 py-2 rounded-pill shadow-sm">
                    Browse Library
                </a>
            </div>
            <!-- Decorative Icon for visual flair -->
            <div class="d-none d-lg-block pe-5">
                <i class="fas fa-book-open fa-5x text-white opacity-50"></i>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Active Borrows (Grid Style) -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-end mb-3">
                    <h5 class="fw-bold m-0">Currently Borrowed</h5>
                    <small class="text-muted">You have <?= count($my_borrows) ?> active items</small>
                </div>

                <?php if(empty($my_borrows)): ?>
                    <div class="card-custom p-5 text-center">
                        <div class="mb-3 text-muted opacity-25">
                            <i class="fas fa-ghost fa-3x"></i>
                        </div>
                        <h6 class="text-muted">No active books found.</h6>
                        <a href="<?= site_url('books') ?>" class="text-primary text-decoration-none small fw-bold">Start reading now &rarr;</a>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach($my_borrows as $item): ?>
                        <?php 
                            $due = $item['due_date'];
                            $today = date('Y-m-d');
                            $isOverdue = ($due < $today);
                        ?>
                        <div class="col-md-6">
                            <div class="book-card shadow-sm h-100 d-flex flex-row align-items-center p-3 gap-3">
                                <!-- Book Cover -->
                                <div class="flex-shrink-0" style="width: 80px; height: 110px;">
                                    <?php if(!empty($item['image'])): ?>
                                        <img src="/uploads/books/<?= esc($item['image']) ?>" 
                                             class="w-100 h-100 rounded-3" 
                                             style="object-fit: cover; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"
                                             alt="Cover">
                                    <?php else: ?>
                                        <div class="w-100 h-100 rounded-3 bg-light d-flex align-items-center justify-content-center text-secondary">
                                            <i class="fas fa-book fa-2x"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Details -->
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold mb-1 text-truncate" style="max-width: 180px;">
                                        <?= esc($item['title'] ?? 'Unknown Title') ?>
                                    </h6>
                                    <p class="text-muted small mb-2">ID: #<?= $item['id'] ?></p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <div class="d-flex flex-column">
                                            <small class="text-muted" style="font-size: 10px;">DUE DATE</small>
                                            <span class="small fw-bold <?= $isOverdue ? 'text-danger' : 'text-dark' ?>">
                                                <?= date('M d', strtotime($due)) ?>
                                            </span>
                                        </div>
                                        
                                        <?php if($isOverdue): ?>
                                            <span class="status-pill status-overdue">Overdue</span>
                                        <?php else: ?>
                                            <span class="status-pill status-active">Reading</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Stats & Quick Actions -->
            <div class="col-lg-4">
                <h5 class="fw-bold mb-3">Statistics</h5>
                
                <!-- Stat Card 1 -->
                <div class="card-custom p-3 mb-3 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: #E2FBD7; color: #34A853;">
                        <i class="fas fa-check"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Total History</h6>
                        <h4 class="fw-bold mb-0"><?= $history_count ?></h4>
                    </div>
                </div>

                <!-- Stat Card 2 (Visual filler for design) -->
                <div class="card-custom p-3 mb-4 d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 50px; height: 50px; background: #FFEAEA; color: #EB5757;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Current Active</h6>
                        <h4 class="fw-bold mb-0"><?= count($my_borrows) ?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('templates/footer') ?>