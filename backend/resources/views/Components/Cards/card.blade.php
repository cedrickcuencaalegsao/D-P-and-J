<div class="card h-100 bg-light border-0 shadow-sm">
    <img src="{{ url('/images/' . (!empty($image) ? $image : 'default.jpg')) }}" class="card-img-top"
        alt="{{ $title ?? 'Card image' }}" style="height: 200px; object-fit: cover;">

    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h5 class="card-title mb-0">{{ $title ?? 'Card Title' }}</h5>
            <span class="badge bg-primary">₱{{ number_format($price ?? 0, 2) }}</span>
        </div>

        <p class="text-muted small mb-2">{{ $category ?? 'No category' }}</p>
        <p class="card-text">{{ $description ?? 'Card description goes here' }}</p>

        <div class="mt-auto d-flex gap-2">
            <button class="btn btn-outline-primary">
                Edit
            </button>
            <button class="btn btn-primary">
                Buy Now
            </button>
        </div>
    </div>
</div>
