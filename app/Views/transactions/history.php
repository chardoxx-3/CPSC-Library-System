<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Circulation Log</h2>
                <p class="text-muted mb-0">Complete history of all library transactions.</p>
            </div>
        </div>

        <?php if(session()->getFlashdata('msg')):?>
            <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-4" style="background-color: #E2FBD7; color: #2D6A4F;">
                <i class="fas fa-check-circle me-2 fs-5"></i>
                <?= session()->getFlashdata('msg') ?>
            </div>
        <?php endif;?>

        <div class="card-custom border-0 p-2">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">ID</th>
                            <th class="py-3 border-0 text-muted small fw-bold text-uppercase">IDs (Book / Mem)</th>
                            <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Borrowed</th>
                            <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Returned</th>
                            <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($transactions as $t): ?>
                        <tr>
                            <td class="ps-4 text-muted small">#<?= $t['id'] ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="badge bg-light text-dark border"><i class="fas fa-book me-1 text-muted"></i> <?= $t['book_id'] ?></span>
                                    <span class="badge bg-light text-dark border"><i class="fas fa-user me-1 text-muted"></i> <?= $t['member_id'] ?></span>
                                </div>
                            </td>
                            <td class="text-muted"><?= date('M d, Y', strtotime($t['borrow_date'])) ?></td>
                            <td>
                                <?php if($t['return_date']): ?>
                                    <span class="text-dark fw-medium"><?= date('M d, Y', strtotime($t['return_date'])) ?></span>
                                <?php else: ?>
                                    <span class="text-muted opacity-50">-</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                    $badgeClass = 'bg-secondary';
                                    if($t['status'] == 'borrowed') $badgeClass = 'bg-primary';
                                    if($t['status'] == 'returned') $badgeClass = 'bg-success';
                                    if($t['status'] == 'overdue') $badgeClass = 'bg-danger';
                                ?>
                                <span class="badge <?= $badgeClass ?> bg-opacity-10 text-<?= str_replace('bg-', '', $badgeClass) ?> rounded-pill px-3">
                                    <?= ucfirst($t['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>

<?= view('templates/footer') ?>