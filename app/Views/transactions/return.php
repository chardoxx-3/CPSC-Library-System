<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1">Process Returns</h2>
                <p class="text-muted mb-0">Manage incoming books from members.</p>
            </div>
            <div class="bg-white px-4 py-2 rounded-pill shadow-sm text-muted">
                Active Borrows: <strong class="text-primary"><?= count($borrows) ?></strong>
            </div>
        </div>

        <div class="card-custom border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-uppercase text-muted small fw-bold">Book Info</th>
                            <th class="py-3 border-0 text-uppercase text-muted small fw-bold">Member</th>
                            <th class="py-3 border-0 text-uppercase text-muted small fw-bold">Dates</th>
                            <th class="py-3 border-0 text-uppercase text-muted small fw-bold">Status</th>
                            <th class="text-end pe-4 py-3 border-0 text-uppercase text-muted small fw-bold">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($borrows)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="mb-3 text-success opacity-50">
                                        <i class="fas fa-check-circle fa-4x"></i>
                                    </div>
                                    <h6 class="text-muted fw-bold">All caught up!</h6>
                                    <p class="text-muted small">No active borrowed books found.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($borrows as $item): ?>
                            <?php 
                                $today = date('Y-m-d');
                                $isOverdue = ($item['due_date'] < $today);
                            ?>
                            <tr class="transition-hover">
                                <!-- Book Info -->
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-3" style="width: 50px; height: 75px;">
                                            <?php if(!empty($item['image'])): ?>
                                                <img src="/uploads/books/<?= esc($item['image']) ?>" class="w-100 h-100 rounded-2 shadow-sm object-fit-cover">
                                            <?php else: ?>
                                                <div class="w-100 h-100 bg-light rounded-2 d-flex align-items-center justify-content-center text-muted border">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark mb-1">
                                                <?php if(!empty($item['title'])): ?>
                                                    <?= esc($item['title']) ?>
                                                <?php else: ?>
                                                    Book ID: <?= $item['book_id'] ?>
                                                <?php endif; ?>
                                            </div>
                                            <small class="text-muted">Trans ID: #<?= $item['id'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Member Info -->
                                <td class="py-3">
                                    <div class="d-flex align-items-center text-muted">
                                        <div class="bg-light rounded-circle p-2 me-2 text-primary">
                                            <i class="fas fa-user small"></i>
                                        </div>
                                        <span class="small fw-medium">
                                            <?php if(!empty($item['full_name'])): ?>
                                                <?= esc($item['full_name']) ?>
                                            <?php else: ?>
                                                Member #<?= $item['member_id'] ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Dates -->
                                <td class="py-3">
                                    <div class="d-flex flex-column small">
                                        <span class="text-muted">Out: <?= date('M d', strtotime($item['borrow_date'])) ?></span>
                                        <span class="<?= $isOverdue ? 'text-danger fw-bold' : 'text-dark' ?>">
                                            Due: <?= date('M d', strtotime($item['due_date'])) ?>
                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-3">
                                    <?php if($isOverdue): ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-2">
                                            <i class="fas fa-exclamation-circle me-1"></i> Overdue
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                            <i class="fas fa-book-reader me-1"></i> Reading
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Action -->
                                <td class="text-end pe-4 py-3">
                                    <a href="<?= site_url('transactions/processReturn/'.$item['id']) ?>" 
                                       class="btn btn-sm btn-outline-success rounded-pill px-3 fw-bold"
                                       onclick="return confirm('Confirm return of this book? System will automatically calculate fines if overdue.')">
                                        <i class="fas fa-undo-alt me-1"></i> Receive
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .object-fit-cover { object-fit: cover; }
    .transition-hover:hover td { background-color: #F8F9FA; }
</style>

<?= view('templates/footer') ?>