<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top w-100">
    <div class="container-fluid">
        <!-- Title on the left -->
        <a class="navbar-brand" href="/dashboard">DP&J</a>

        <!-- Toggler button for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation links on the right -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard*') ? 'active fw-bold' : '' }}"
                        href="/dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('products*') ? 'active fw-bold' : '' }}"
                        href="/products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('category*') ? 'active fw-bold' : '' }}"
                        href="/category">Category</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('stocks*') ? 'active fw-bold' : '' }}" href="/stocks">Stocks</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('sales*') ? 'active fw-bold' : '' }}" href="/sales">Sales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('report*') ? 'active fw-bold' : '' }}" href="/report">Report</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('logout*') ? 'active fw-bold' : '' }}" href="/logout">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
