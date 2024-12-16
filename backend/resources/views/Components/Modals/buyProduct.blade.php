<div class="modal fade" id="buyProductModal" tabindex="-1" aria-labelledby="buyProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buyProductModalLabel">Buy Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="buyProductForm" action="{{ route('buyProduct') }}" method="POST">
                @csrf
                <input type="hidden" id="buy_product_id" name="product_id">
                <input type="hidden" id="buy_retrieve_price" name="retrieve_price">
                <input type="hidden" id="buy_retailed_price" name="retailed_price">
                <div class="modal-body">
                    <div class="mb-3">
                        <h6>Product: <span id="product_name"></span></h6>
                        <h6>Price: $<span id="product_price"></span></h6>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1"
                            value="0">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Purchase</button>
                </div>
            </form>
        </div>
    </div>
</div>
