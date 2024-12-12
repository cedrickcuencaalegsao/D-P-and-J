<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('updateProduct') }}" method="POST" enctype="multipart/form-data"
                id="editProductForm">
                @csrf
                <input type="hidden" id="edit_product_id" name="product_id">
                <div class="modal-body">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="edit_category" name="category" required>
                    </div>

                    <!-- Price -->
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="edit_price" name="price"
                            required>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="edit_image" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="edit_image" name="image" accept="image/*">
                        <div id="currentImage" class="mt-2">
                            <p class="text-muted">Current image: <span id="imageName"></span></p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
