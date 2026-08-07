<?= view('templates/header') ?>

<div class="d-flex">
    <!-- Sidebar -->
    <?= view('templates/sidebar') ?>

    <!-- Main Content -->
    <div class="main-content w-100">
        
        <!-- Header & Back Button -->
        <div class="d-flex align-items-center mb-4">
            <a href="<?= site_url('books') ?>" class="btn btn-light rounded-circle shadow-sm me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-arrow-left text-muted"></i>
            </a>
            <div>
                <h2 class="fw-bold text-dark mb-0">Add New Book</h2>
                <p class="text-muted small mb-0">Expand the library collection</p>
            </div>
        </div>

        <div class="card-custom p-4 border-0" style="max-width: 900px;">
            <form action="<?= site_url('books/store') ?>" method="post" enctype="multipart/form-data">
                
                <div class="row g-4">
                    <!-- Left Column: Image Upload -->
                    <div class="col-lg-4 text-center">
                        <div class="p-4 rounded-4 bg-light h-100 d-flex flex-column justify-content-center align-items-center dashed-border">
                            <div id="imagePreview" class="mb-3">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted opacity-50"></i>
                            </div>
                            <label for="imageInput" class="btn btn-outline-primary rounded-pill btn-sm px-4 mb-2">
                                <i class="fas fa-camera me-2"></i> Choose Cover
                            </label>
                            <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                            <small class="text-muted" style="font-size: 0.7rem;">Max 2MB (JPG/PNG)</small>
                            <button type="button" class="btn btn-link text-danger text-decoration-none small mt-2" onclick="clearImage()">Remove</button>
                        </div>
                    </div>

                    <!-- Right Column: Details -->
                    <div class="col-lg-8">
                        <h6 class="text-uppercase text-primary fw-bold mb-3 small" style="letter-spacing: 1px;">Book Details</h6>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small fw-bold">Book Title</label>
                            <input type="text" name="title" class="form-control form-control-lg rounded-3 border-0 bg-light" placeholder="e.g. Introduction to Algorithms" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Author</label>
                                <input type="text" name="author" class="form-control rounded-3 border-0 bg-light" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Publisher</label>
                                <input type="text" name="publisher" class="form-control rounded-3 border-0 bg-light">
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Year</label>
                                <input type="number" name="year" class="form-control rounded-3 border-0 bg-light" placeholder="2024" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Category</label>
                                <select name="category" class="form-select rounded-3 border-0 bg-light">
                                    <option value="General">General</option>
                                    <option value="Science">Science</option>
                                    <option value="Technology">Technology</option>
                                    <option value="History">History</option>
                                    <option value="Fiction">Fiction</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">ISBN</label>
                                <input type="text" name="isbn" class="form-control rounded-3 border-0 bg-light">
                            </div>
                        </div>

                        <h6 class="text-uppercase text-primary fw-bold mb-3 small mt-4" style="letter-spacing: 1px;">Inventory Control</h6>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Copies Available</label>
                                <input type="number" name="quantity" class="form-control rounded-3 border-0 bg-light" value="1" min="1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Shelf Location</label>
                                <input type="text" name="shelf_location" class="form-control rounded-3 border-0 bg-light" placeholder="e.g. A-12">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= site_url('books') ?>" class="btn btn-light rounded-pill px-4">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">Save Book</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .dashed-border {
        border: 2px dashed #E0E0E0;
    }
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        background: #fff;
        border: 1px solid var(--primary);
    }
</style>

<script>
// Logic preserved
const defaultPreview = '<i class="fas fa-cloud-upload-alt fa-3x text-muted opacity-50"></i>';

document.getElementById('imageInput').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-fluid rounded shadow-sm';
            img.style.maxHeight = '180px';
            preview.appendChild(img);
        }
        reader.readAsDataURL(this.files[0]);
    } else {
        preview.innerHTML = defaultPreview;
    }
});

function clearImage() {
    document.getElementById('imageInput').value = '';
    document.getElementById('imagePreview').innerHTML = defaultPreview;
}
</script>

<?= view('templates/footer') ?>