<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <!-- Header -->
        <div class="d-flex align-items-center mb-4">
            <a href="<?= site_url('transactions/history') ?>" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-0">Issue New Book</h2>
                <p class="text-muted small mb-0">Create a new borrowing record.</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left: Form -->
            <div class="col-lg-8">
                <div class="card-custom p-4 border-0">
                    <form action="<?= site_url('transactions/saveBorrow') ?>" method="post">
                        
                        <div class="mb-4 position-relative">
                            <label class="form-label text-muted small fw-bold text-uppercase">Select Member</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill ps-3"><i class="fas fa-user text-muted"></i></span>
                                <select name="member_id" class="form-select border-0 bg-light rounded-end-pill py-3 ps-2" style="font-size: 0.95rem;" required>
                                    <option value="" disabled selected>-- Choose Library Member --</option>
                                    <?php foreach($members as $member): ?>
                                        <option value="<?= $member['id'] ?>">
                                            <?= esc($member['full_name']) ?> (ID: <?= $member['user_id'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4 position-relative">
                            <label class="form-label text-muted small fw-bold text-uppercase">Select Book</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 rounded-start-pill ps-3"><i class="fas fa-book text-muted"></i></span>
                                <select name="book_id" class="form-select border-0 bg-light rounded-end-pill py-3 ps-2" style="font-size: 0.95rem;" required>
                                    <option value="" disabled selected>-- Choose Book from Inventory --</option>
                                    <?php foreach($books as $book): ?>
                                        <option value="<?= $book['id'] ?>">
                                            <?= esc($book['title']) ?> (ISBN: <?= $book['isbn'] ?>) - Shelf: <?= $book['shelf_location'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <small class="text-muted ms-2 mt-1 d-block"><i class="fas fa-check-circle text-success me-1"></i> Only available books are shown.</small>
                        </div>

                        <div class="bg-light p-4 rounded-4 mb-4">
                            <div class="row text-center">
                                <div class="col-6 border-end">
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Issue Date</small>
                                    <div class="h5 fw-bold text-dark mt-1 mb-0"><?= date('M j, Y') ?></div>
                                </div>
                                <div class="col-6">
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Due Date</small>
                                    <div class="h5 fw-bold text-primary mt-1 mb-0"><?= date('M j, Y', strtotime('+7 days')) ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill py-3 shadow-lg btn-block fw-bold">
                                Confirm & Issue Book <i class="fas fa-paper-plane ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right: Policy Info -->
            <div class="col-lg-4">
                <div class="card-custom border-0 p-4 h-100 bg-gradient-policy text-white">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-white bg-opacity-25 p-2 rounded-3 me-3">
                            <i class="fas fa-shield-alt fa-lg"></i>
                        </div>
                        <h6 class="fw-bold mb-0">Lending Policy</h6>
                    </div>
                    
                    <ul class="list-unstyled opacity-75 small mb-0 d-flex flex-column gap-3">
                        <li class="d-flex align-items-start">
                            <i class="fas fa-circle me-3 mt-1" style="font-size: 6px;"></i>
                            <span>Standard lending period is strictly <strong>7 days</strong>.</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-circle me-3 mt-1" style="font-size: 6px;"></i>
                            <span>Late returns incur a fine of <strong>10 PHP per day</strong>.</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-circle me-3 mt-1" style="font-size: 6px;"></i>
                            <span>Members with outstanding fines cannot borrow new items.</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-circle me-3 mt-1" style="font-size: 6px;"></i>
                            <span>Lost books must be reported immediately to the admin.</span>
                        </li>
                    </ul>

                    <div class="mt-auto pt-4 text-center opacity-50">
                        <i class="fas fa-book-reader fa-5x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-gradient-policy {
        background: linear-gradient(145deg, #4D44B5 0%, #342E7A 100%);
    }
    .form-select:focus {
        box-shadow: none;
        background-color: #fff;
        border: 2px solid var(--primary) !important;
    }
</style>

<?= view('templates/footer') ?>