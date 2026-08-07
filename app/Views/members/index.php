<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1">Library Members</h2>
                <p class="text-muted mb-0">Manage registered users and their details.</p>
            </div>
            
            <a href="<?= base_url('members/print') ?>" target="_blank" class="btn btn-outline-primary rounded-pill px-4 d-flex align-items-center gap-2">
                <i class="fas fa-print"></i> <span>Print List</span>
            </a>
        </div>

        <!-- Members Table Card -->
        <div class="card-custom border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" style="border-collapse: separate; border-spacing: 0;">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-muted small text-uppercase fw-bold border-0">Member Info</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold border-0">Contact Info</th>
                            <th class="py-3 text-muted small text-uppercase fw-bold border-0">Status</th>
                            <th class="text-end pe-4 py-3 text-muted small text-uppercase fw-bold border-0">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($members)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted opacity-50 mb-2"><i class="fas fa-users-slash fa-3x"></i></div>
                                    <h6 class="text-muted">No members registered yet.</h6>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($members as $member): ?>
                            <tr class="transition-hover">
                                <!-- Member Info -->
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <!-- Initials Avatar -->
                                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm text-white fw-bold" 
                                             style="width: 45px; height: 45px; background: linear-gradient(135deg, #6C5DD3, #8B5CF6);">
                                            <?= strtoupper(substr($member['full_name'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark"><?= esc($member['full_name']) ?></div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-light text-muted border rounded-pill fw-normal" style="font-size: 0.7rem;">ID: #<?= $member['user_id'] ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Contact Info -->
                                <td class="py-3">
                                    <div class="d-flex flex-col text-muted small">
                                        <div class="mb-1"><i class="fas fa-map-marker-alt me-2 text-primary opacity-50" style="width: 15px;"></i><?= esc($member['address']) ?></div>
                                        <div><i class="fas fa-phone me-2 text-success opacity-50" style="width: 15px;"></i><?= esc($member['contact_number']) ?></div>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="py-3">
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i> Active
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="text-end pe-4 py-3">
                                    <a href="<?= base_url('members/view/' . $member['id']) ?>" 
                                       class="btn btn-light btn-sm text-primary rounded-pill px-3 shadow-sm fw-bold" 
                                       style="font-size: 0.8rem;">
                                        View Details <i class="fas fa-chevron-right ms-1"></i>
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
    .transition-hover:hover td {
        background-color: #F8F9FA;
    }
</style>

<?= view('templates/footer') ?>