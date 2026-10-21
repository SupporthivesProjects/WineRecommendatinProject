<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark fixed-top transparent-navbar">
    <div class="container d-flex align-items-center">

        {{-- Hamburger on the right --}}
        <button class="navbar-toggler ms-auto" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">

            {{-- Left navigation links --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.showQuestionnaire') }}" class="nav-link">Questionnaires</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.products') }}" class="nav-link">Browse Wines</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.cheeses') }}" class="nav-link">Browse Cheeses</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.featuredproducts') }}" class="nav-link">Featured Products</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user.cart') }}" class="nav-link">
                        View Cart (<span id="cart-count">{{ collect($cart ?? [])->sum('quantity') }}</span>)
                    </a>
                </li>
            </ul>

            {{-- Logout --}}
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <a class="nav-link d-flex align-items-center"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fe fe-power fs-16 align-middle me-2"></i>
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>
            </ul>

        </div>
    </div>
</nav>
