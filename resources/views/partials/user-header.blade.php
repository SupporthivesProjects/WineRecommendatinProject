<nav id="mainNavbar" class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid navbar-inner">

        {{-- Logo: LEFT --}}
        <a href="{{ route('user.dashboard') }}" class="navbar-logo">
            <img src="{{ asset('images/logoblackyellow.png') }}" alt="TechSomm Logo">
        </a>

        {{-- Hamburger: RIGHT on mobile --}}
        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">
            <span class="hamburger-icon">
                <span></span>
                <span></span>
                <span></span>
            </span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            {{-- Navigation links: CENTER --}}
            <ul class="navbar-nav main-nav">
                <li class="nav-item">
                    <a href="{{ route('user.dashboard') }}"
                       class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.showQuestionnaire') }}"
                       class="nav-link {{ request()->routeIs('user.showQuestionnaire') ? 'active' : '' }}">
                        Questionnaires
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.products') }}"
                       class="nav-link {{ request()->routeIs('user.products') ? 'active' : '' }}">
                        Browse Wines
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.cheeses') }}"
                       class="nav-link {{ request()->routeIs('user.cheeses', 'user.cheese.show') ? 'active' : '' }}">
                        Browse Cheeses
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.featuredproducts') }}"
                       class="nav-link {{ request()->routeIs('user.featuredproducts') ? 'active' : '' }}">
                        Featured Products
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('user.cart') }}"
                       class="nav-link {{ request()->routeIs('user.cart') ? 'active' : '' }}">
                        View Cart (<span id="cart-count">{{ collect($cart ?? [])->sum('quantity') }}</span>)
                    </a>
                </li>

                {{-- Logout: RIGHT --}}
                <li class="nav-item logout-mobile">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-link logout-link">
                            <i class="fe fe-power fs-16 align-middle me-2"></i>
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </li>
            </ul>

            {{-- Separate desktop logout --}}
            <div class="desktop-logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link logout-link">
                        <i class="fe fe-power fs-16 align-middle me-2"></i>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
