<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between flex-wrap align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1">Library Inventory</h2>
                <p class="text-muted mb-0">Manage your books and catalog.</p>
            </div>
            
            <?php if(session()->get('role') == 'admin'): ?>
                <a href="<?= site_url('books/add') ?>" class="btn btn-primary rounded-pill px-4 shadow-sm d-flex align-items-center gap-2">
                    <i class="fas fa-plus-circle"></i> <span>Add New Book</span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Books List -->
        <div class="card-custom border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small text-uppercase fw-bold border-0">Book</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold border-0">Details</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold border-0">Status</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold border-0">Location</th>
                            <?php if(session()->get('role') == 'admin'): ?>
                            <th class="text-end pe-4 py-3 text-muted small text-uppercase fw-bold border-0">Actions</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($books)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2"><i class="fas fa-book-open fa-3x"></i></div>
                                    <h6 class="text-muted">No books found in the library.</h6>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($books as $book): ?>
                            <tr class="transition-hover">
                                <!-- Cover Image -->
                                <td class="ps-4 py-3" width="100">
                                    <div class="position-relative" style="width: 60px; height: 85px;">
                                        <?php if(!empty($book['image'])): ?>
                                            <img src="/uploads/books/<?= esc($book['image']) ?>" 
                                                 alt="Cover" 
                                                 class="w-100 h-100 rounded-3 shadow-sm" 
                                                 style="object-fit: cover;">
                                        <?php else: ?>
                                            <div class="w-100 h-100 rounded-3 bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center text-muted">
                                                <i class="fas fa-book"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                
                                <!-- Details -->
                                <td class="py-3">
                                    <h6 class="fw-bold text-dark mb-1"><?= esc($book['title']) ?></h6>
                                    <div class="d-flex align-items-center gap-2 text-muted small">
                                        <span><i class="fas fa-user-edit me-1"></i><?= esc($book['author']) ?></span>
                                        <span>&bull;</span>
                                        <span><?= esc($book['year']) ?></span>
                                    </div>
                                    <div class="mt-1">
                                        <span class="badge bg-light text-secondary border border-secondary border-opacity-25 rounded-pill fw-normal">
                                            <?= esc($book['category']) ?>
                                        </span>
                                        <small class="text-muted ms-2">ISBN: <?= esc($book['isbn']) ?></small>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-3">
                                    <?php if($book['quantity'] > 0): ?>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block bg-success rounded-circle p-1 me-2"></span>
                                            <span class="text-success fw-bold small">Available</span>
                                            <span class="badge bg-success bg-opacity-10 text-success ms-2 rounded-pill"><?= $book['quantity'] ?></span>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center">
                                            <span class="d-inline-block bg-danger rounded-circle p-1 me-2"></span>
                                            <span class="text-danger fw-bold small">Out of Stock</span>
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <!-- Location -->
                                <td class="py-3">
                                    <div class="d-flex align-items-center text-muted">
                                        <i class="fas fa-map-marker-alt me-2 text-primary opacity-50"></i>
                                        <span class="fw-medium small"><?= esc($book['shelf_location'] ?: 'N/A') ?></span>
                                    </div>
                                </td>
                                
                                <!-- Actions -->
                                <?php if(session()->get('role') == 'admin'): ?>
                                <td class="text-end pe-4 py-3">
                                    <a href="<?= site_url('books/edit/'.$book['id']) ?>" class="btn btn-light btn-sm text-primary rounded-circle shadow-sm me-1" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="<?= site_url('books/delete/'.$book['id']) ?>" 
                                       class="btn btn-light btn-sm text-danger rounded-circle shadow-sm" 
                                       onclick="return confirm('Are you sure you want to remove this book?');" 
                                       title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                <?php endif; ?>
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
    /* Subtle hover effect for rows */
    .transition-hover:hover td {
        background-color: #F8F9FA;
        cursor: default;
    }
</style>

<?= view('templates/footer') ?>