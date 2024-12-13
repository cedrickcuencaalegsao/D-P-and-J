<div class="modal fade" id="editStockModal{{ $stock->getId() }}" tabindex="-1"
    aria-labelledby="editStockModalLabel{{ $stock->getId() }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockModalLabel{{ $stock->getId() }}">Edit Stock - {{ $stock->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editStockForm{{ $stock->getId() }}" method="POST" action="{{ route('updateStock') }}">
                @csrf
                <input type="hidden" name="product_id" value="{{ $stock->getByProductID() }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_stock_quantity{{ $stock->getId() }}" class="form-label">Stock Quantity</label>
                        <input type="number" class="form-control" id="edit_stock_quantity{{ $stock->getId() }}"
                            name="stocks" value="{{ $stock->getStocks() }}" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Stock</button>
                </div>
            </form>
        </div>
    </div>
</div>
