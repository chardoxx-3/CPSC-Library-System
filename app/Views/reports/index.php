<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1">Library Reports</h2>
                <p class="text-muted mb-0">Generate insights and track inventory status.</p>
            </div>
            
            <!-- Quick Filter (Visible when a report is active) -->
            <?php if(!empty($report_type)): ?>
                <div class="bg-white p-2 rounded-pill shadow-sm d-flex gap-2 no-print">
                    <form action="<?= site_url('reports') ?>" method="get" class="d-flex align-items-center gap-2">
                        <select name="type" class="form-select border-0 bg-light rounded-pill px-3 py-2" style="width: 250px; font-size: 0.9rem;">
                            <option value="borrowed_books" <?= ($report_type == 'borrowed_books') ? 'selected' : '' ?>>Borrowed Books (Active)</option>
                            <option value="overdue" <?= ($report_type == 'overdue') ? 'selected' : '' ?>>Overdue Books (Late)</option>
                            <option value="available_books" <?= ($report_type == 'available_books') ? 'selected' : '' ?>>Available Inventory</option>
                        </select>
                        <button type="submit" class="btn btn-primary rounded-circle shadow-sm" style="width: 38px; height: 38px;">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </form>
                    <div class="vr my-2 opacity-25"></div>
                    <button onclick="openPrintPage('<?= $report_type ?>')" class="btn btn-outline-secondary rounded-pill px-3 py-2 small fw-bold">
                        <i class="fas fa-print me-2"></i> Print
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <?php if(empty($report_type)): ?>
            <!-- EMPTY STATE: Quick Selection Cards -->
            <div class="text-center py-4 mb-4">
                <h5 class="text-muted fw-light mb-5">Select a report category to get started</h5>
                
                <div class="row g-4 justify-content-center">
                    <!-- Option 1: Inventory -->
                    <div class="col-md-4 col-lg-3">
                        <a href="<?= site_url('reports?type=available_books') ?>" class="text-decoration-none">
                            <div class="card-custom p-4 h-100 hover-scale text-center border border-transparent">
                                <div class="mb-4 bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-book fa-2x"></i>
                                </div>
                                <h5 class="text-dark fw-bold">Inventory</h5>
                                <p class="text-muted small mb-0">List of all available books currently on shelves.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Option 2: Active Borrows -->
                    <div class="col-md-4 col-lg-3">
                        <a href="<?= site_url('reports?type=borrowed_books') ?>" class="text-decoration-none">
                            <div class="card-custom p-4 h-100 hover-scale text-center border border-transparent">
                                <div class="mb-4 bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-hand-holding fa-2x"></i>
                                </div>
                                <h5 class="text-dark fw-bold">Borrowed</h5>
                                <p class="text-muted small mb-0">Books currently issued to members.</p>
                            </div>
                        </a>
                    </div>

                    <!-- Option 3: Overdue -->
                    <div class="col-md-4 col-lg-3">
                        <a href="<?= site_url('reports?type=overdue') ?>" class="text-decoration-none">
                            <div class="card-custom p-4 h-100 hover-scale text-center border border-transparent">
                                <div class="mb-4 bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                                <h5 class="text-dark fw-bold">Overdue</h5>
                                <p class="text-muted small mb-0">Items past due date requiring attention.</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        <?php else: ?>
            
            <!-- RESULTS: Data Table -->
            <div class="card-custom border-0 overflow-hidden">
                <!-- Table Header Context -->
                <div class="px-4 py-3 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-muted small text-uppercase fw-bold">Results For:</span>
                        <span class="text-primary fw-bold ms-2 text-capitalize"><?= str_replace('_', ' ', $report_type) ?></span>
                    </div>
                    <span class="badge bg-white text-dark border shadow-sm rounded-pill px-3">
                        Count: <?= count($results) ?>
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-white">
                            <tr>
                                <th class="ps-4 py-3 text-muted small fw-bold text-uppercase border-0">Cover</th>
                                <?php if($report_type == 'available_books'): ?>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Book Details</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Category</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Stock</th>
                                <?php else: ?>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Transaction</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Member</th>
                                    <th class="py-3 text-muted small fw-bold text-uppercase border-0">Timeline</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($results)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="mb-3 opacity-25 text-muted">
                                            <i class="fas fa-search fa-3x"></i>
                                        </div>
                                        <h6 class="text-muted">No records found.</h6>
                                        <a href="<?= site_url('reports') ?>" class="btn btn-sm btn-link text-decoration-none">Clear Filters</a>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($results as $row): ?>
                                <tr class="transition-hover">
                                    <!-- Cover Column -->
                                    <td class="ps-4 py-3" width="80">
                                        <div class="rounded-3 overflow-hidden shadow-sm position-relative" style="width: 50px; height: 75px;">
                                            <?php if(!empty($row['image'])): ?>
                                                <img src="/uploads/books/<?= esc($row['image']) ?>" class="w-100 h-100" style="object-fit: cover;">
                                            <?php else: ?>
                                                <div class="w-100 h-100 bg-light d-flex align-items-center justify-content-center text-muted">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <?php if($report_type == 'available_books'): ?>
                                        <!-- Inventory Columns -->
                                        <td>
                                            <div class="fw-bold text-dark"><?= esc($row['title']) ?></div>
                                            <div class="small text-muted"><?= esc($row['author']) ?></div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-secondary border rounded-pill fw-normal">
                                                <?= esc($row['category']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php 
                                                $qty = $row['quantity'];
                                                $qClass = $qty > 5 ? 'success' : ($qty > 0 ? 'warning' : 'danger');
                                            ?>
                                            <div class="d-flex align-items-center">
                                                <span class="d-inline-block p-1 rounded-circle bg-<?= $qClass ?> me-2"></span>
                                                <span class="fw-bold text-dark"><?= $qty ?></span>
                                            </div>
                                        </td>
                                    <?php else: ?>
                                        <!-- Transaction Columns -->
                                        <td>
                                            <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">
                                                <?= esc($row['title'] ?? 'Book #' . $row['book_id']) ?>
                                            </div>
                                            <div class="small text-muted">Trans ID: #<?= $row['id'] ?></div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle p-1 me-2 text-primary">
                                                    <i class="fas fa-user small"></i>
                                                </div>
                                                <span class="small fw-medium text-dark">
                                                    <?= esc($row['full_name'] ?? 'Member #' . $row['member_id']) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php 
                                                $dueDate = $row['due_date'];
                                                $today = date('Y-m-d');
                                                $isOverdue = $report_type == 'overdue' || $dueDate < $today;
                                            ?>
                                            <div class="d-flex flex-column small">
                                                <span class="text-muted">Out: <?= date('M d', strtotime($row['borrow_date'])) ?></span>
                                                <span class="<?= $isOverdue ? 'text-danger fw-bold' : 'text-dark' ?>">
                                                    Due: <?= date('M d', strtotime($dueDate)) ?>
                                                </span>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- Print Styles & Script -->
<style>
    .hover-scale {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(108, 93, 211, 0.1);
        border-color: var(--primary) !important;
    }
    .transition-hover:hover td {
        background-color: #F8F9FA;
    }

    @media print {
        .no-print, .sidebar, header, .vr { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .card-custom { box-shadow: none !important; border: 1px solid #ddd !important; }
        .badge { border: 1px solid #000; color: #000 !important; }
        body { background: white !important; }
    }
</style>

<script>
function openPrintPage(reportType) {
    const url = '<?= site_url("reports/print/") ?>' + reportType;
    const printWindow = window.open(url, '_blank', 'width=800,height=600,scrollbars=yes');
    if (printWindow) printWindow.focus();
    else alert('Please allow popups for this site to print reports.');
}
</script>

<?= view('templates/footer') ?>