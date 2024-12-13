<div class="modal fade" id="editCategoryModal{{ $category['id'] }}" tabindex="-1"
    aria-labelledby="editCategoryModalLabel{{ $category['id'] }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel{{ $category['id'] }}">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editCategoryForm{{ $category['id'] }}" method="POST" action="{{ route('updateCategory') }}">
                @csrf
                {{-- {{ dd($category) }} --}}
                <input type="hidden" name="product_id" value="{{ $category['product_id'] }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_category_name{{ $category['id'] }}" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="edit_category_name{{ $category['id'] }}"
                            name="category" value="{{ $category['category'] }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
