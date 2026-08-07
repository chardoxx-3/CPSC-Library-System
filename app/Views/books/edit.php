<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <div class="d-flex align-items-center mb-4">
            <a href="<?= site_url('books') ?>" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-0">Edit Book</h2>
                <p class="text-muted small mb-0">Update details for "<?= esc($book['title']) ?>"</p>
            </div>
        </div>

        <div class="card-custom p-4 border-0" style="max-width: 900px;">
            <form action="<?= site_url('books/update') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $book['id'] ?>">
                <!-- Hidden inputs for logic -->
                <input type="hidden" name="remove_image" id="removeImage" value="0">

                <div class="row g-4">
                    <!-- Left: Image Logic -->
                    <div class="col-lg-4">
                        <div class="p-3 bg-white rounded-4 shadow-sm text-center h-100 border">
                            <h6 class="text-muted small fw-bold mb-3">Book Cover</h6>
                            
                            <div id="imagePreviewWrapper" class="mb-3 position-relative d-inline-block">
                                <?php if(!empty($book['image'])): ?>
                                    <img src="/uploads/books/<?= esc($book['image']) ?>" 
                                         id="currentDisplayImg"
                                         class="img-fluid rounded-3 shadow-sm" 
                                         style="max-height: 200px;" 
                                         alt="Cover">
                                    <div id="trashIcon" class="position-absolute top-0 end-0 m-2">
                                        <button type="button" class="btn btn-danger btn-sm rounded-circle shadow" onclick="markRemoveImage()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 200px; width: 100%;">
                                        <i class="fas fa-book fa-3x text-muted opacity-25"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="d-grid gap-2">
                                <label class="btn btn-primary rounded-pill btn-sm">
                                    <i class="fas fa-upload me-1"></i> Change Cover
                                    <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                </label>
                            </div>
                            <div id="newPreviewArea" class="mt-2"></div>
                        </div>
                    </div>

                    <!-- Right: Form Fields -->
                    <div class="col-lg-8">
                        <div class="row g-3 mb-3">
                            <div class="col-12">
                                <label class="form-label text-muted small fw-bold">Title</label>
                                <input type="text" name="title" class="form-control rounded-3 border-0 bg-light p-3" value="<?= esc($book['title']) ?>" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Author</label>
                                <input type="text" name="author" class="form-control rounded-3 border-0 bg-light" value="<?= esc($book['author']) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Publisher</label>
                                <input type="text" name="publisher" class="form-control rounded-3 border-0 bg-light" value="<?= esc($book['publisher']) ?>">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Year</label>
                                <input type="number" name="year" class="form-control rounded-3 border-0 bg-light" value="<?= esc($book['year']) ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Category</label>
                                <select name="category" class="form-select rounded-3 border-0 bg-light">
                                    <option value="General" <?= ($book['category'] == 'General') ? 'selected' : '' ?>>General</option>
                                    <option value="Science" <?= ($book['category'] == 'Science') ? 'selected' : '' ?>>Science</option>
                                    <option value="Technology" <?= ($book['category'] == 'Technology') ? 'selected' : '' ?>>Technology</option>
                                    <option value="History" <?= ($book['category'] == 'History') ? 'selected' : '' ?>>History</option>
                                    <option value="Fiction" <?= ($book['category'] == 'Fiction') ? 'selected' : '' ?>>Fiction</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">ISBN</label>
                                <input type="text" name="isbn" class="form-control rounded-3 border-0 bg-light" value="<?= esc($book['isbn']) ?>">
                            </div>
                        </div>

                        <div class="bg-light p-3 rounded-3 mb-3">
                            <h6 class="text-primary fw-bold small mb-3">Inventory Status</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Copies</label>
                                    <input type="number" name="quantity" class="form-control border-0 bg-white" value="<?= esc($book['quantity']) ?>" min="0" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small text-muted">Location</label>
                                    <input type="text" name="shelf_location" class="form-control border-0 bg-white" value="<?= esc($book['shelf_location']) ?>">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="<?= site_url('books') ?>" class="btn btn-outline-secondary rounded-pill px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">Save Changes</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Image Handling Logic
function markRemoveImage() {
    if(confirm('Are you sure you want to remove the current cover?')) {
        document.getElementById('removeImage').value = '1';
        document.getElementById('currentDisplayImg').style.opacity = '0.3';
        document.getElementById('trashIcon').style.display = 'none';
    }
}

document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('newPreviewArea');
    preview.innerHTML = '';
    
    if (this.files && this.files[0]) {
        // Reset remove flag if user uploads new one
        document.getElementById('removeImage').value = '0';
        
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-thumbnail mt-2';
            img.style.maxWidth = '100px';
            preview.appendChild(img);
        }
        reader.readAsDataURL(this.files[0]);
    }
});
</script>

<?= view('templates/footer') ?>