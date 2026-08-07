<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <!-- Header & Back Button -->
        <div class="d-flex align-items-center mb-4">
            <a href="<?= base_url('members') ?>" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-0">Member Profile</h2>
                <p class="text-muted small mb-0">Detailed view and transaction history</p>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Profile Card -->
            <div class="col-lg-4">
                <div class="card-custom border-0 h-100 position-relative overflow-hidden">
                    <!-- Background decoration -->
                    <div style="height: 100px; background: linear-gradient(135deg, #6C5DD3, #8B5CF6);"></div>
                    
                    <div class="text-center px-4 pb-4" style="margin-top: -50px;">
                        <div class="mx-auto mb-3 bg-white p-1 rounded-circle shadow-sm d-inline-block">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" 
                                 style="width: 100px; height: 100px; background: #FF9F43; font-size: 2.5rem;">
                                <?= strtoupper(substr($member['full_name'], 0, 1)) ?>
                            </div>
                        </div>
                        
                        <h4 class="fw-bold mb-1"><?= esc($member['full_name']) ?></h4>
                        <span class="badge bg-light text-primary rounded-pill px-3 mb-4">Library Member</span>
                        
                        <!-- Details Grid -->
                        <div class="text-start bg-light rounded-4 p-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Member ID</small>
                                    <div class="fw-bold text-dark">#<?= $member['id'] ?></div>
                                </div>
                                <div class="col-12">
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Contact Number</small>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-phone-alt text-muted me-2 small"></i>
                                        <span class="fw-medium"><?= esc($member['contact_number']) ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Address</small>
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-muted me-2 small"></i>
                                        <span class="fw-medium"><?= esc($member['address']) ?></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Joined Date</small>
                                    <div class="fw-medium"><?= date('M j, Y', strtotime($member['created_at'])) ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 d-grid">
                             <a href="<?= base_url('transactions/borrow?member=' . $member['id']) ?>" 
                               class="btn btn-primary rounded-pill py-2 shadow-sm">
                                <i class="fas fa-plus-circle me-2"></i> Issue New Book
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Transactions -->
            <div class="col-lg-8">
                <div class="card-custom border-0 h-100 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-0">Borrowing History</h5>
                            <p class="text-muted small mb-0">Track all book movements for this user.</p>
                        </div>
                        <div class="bg-light px-3 py-1 rounded-pill">
                            <span class="fw-bold text-primary"><?= count($transactions) ?></span> <span class="small text-muted">Records</span>
                        </div>
                    </div>

                    <?php if(empty($transactions)): ?>
                        <div class="text-center py-5 rounded-3 bg-light border border-dashed">
                            <div class="mb-3 opacity-25 text-primary">
                                <i class="fas fa-folder-open fa-3x"></i>
                            </div>
                            <h6 class="text-muted fw-bold">No History Found</h6>
                            <p class="small text-muted mb-0">This member has not borrowed any books yet.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="bg-light rounded-3">
                                    <tr>
                                        <th class="ps-3 py-3 border-0 rounded-start text-muted small fw-bold text-uppercase">Book Details</th>
                                        <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Dates</th>
                                        <th class="py-3 border-0 rounded-end text-muted small fw-bold text-uppercase text-end pe-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($transactions as $transaction): ?>
                                        <tr>
                                            <td class="ps-3 py-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-primary bg-opacity-10 text-primary rounded p-2 me-3">
                                                        <i class="fas fa-book"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark"><?= esc($transaction['title']) ?></div>
                                                        <div class="text-muted small"><?= esc($transaction['author']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-3">
                                                <div class="d-flex flex-column small">
                                                    <span class="text-muted">Borrowed: <span class="text-dark fw-bold"><?= date('M d', strtotime($transaction['borrow_date'])) ?></span></span>
                                                    <span class="text-muted">Due: <span class="<?= (strtotime($transaction['due_date']) < time() && $transaction['status'] == 'borrowed') ? 'text-danger fw-bold' : 'text-dark fw-bold' ?>"><?= date('M d', strtotime($transaction['due_date'])) ?></span></span>
                                                </div>
                                            </td>
                                            <td class="text-end pe-3 py-3">
                                                <?php
                                                    $status = $transaction['status'];
                                                    $statusClass = 'bg-secondary';
                                                    $icon = 'fa-minus';
                                                    
                                                    if($status == 'borrowed') { 
                                                        $statusClass = 'bg-warning text-warning bg-opacity-10'; 
                                                        $icon = 'fa-clock';
                                                    }
                                                    if($status == 'returned') { 
                                                        $statusClass = 'bg-success text-success bg-opacity-10'; 
                                                        $icon = 'fa-check';
                                                    }
                                                    if($status == 'overdue') { 
                                                        $statusClass = 'bg-danger text-danger bg-opacity-10'; 
                                                        $icon = 'fa-exclamation-circle';
                                                    }
                                                ?>
                                                <span class="badge rounded-pill <?= $statusClass ?> px-3 py-2">
                                                    <i class="fas <?= $icon ?> me-1"></i> <?= ucfirst($status) ?>
                                                </span>
                                                
                                                <?php if($transaction['return_date']): ?>
                                                    <div class="small text-muted mt-1">
                                                        Ret: <?= date('M d', strtotime($transaction['return_date'])) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-dashed { border-style: dashed !important; }
</style>

<?= view('templates/footer') ?>