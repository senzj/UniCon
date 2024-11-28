<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid flex-column align-items-center">
        <!-- Navbar Brand - Centered Above the Collapse -->
        <a class="navbar-brand" href="/"> <img src="{{ asset('assets/images/logo_horizontal.png') }}" alt="Logo" style="height: 130px;"> </a>

        <!-- Navbar Toggler (Visible on smaller screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mb-2 mb-lg-0">
                {{-- checks if user is logged in or not --}}
                @if (Auth::check())

                    {{-- checks if the user role is admin --}}
                    @if (Auth::user()->role == 'admin')
                        <!-- Add admin-specific links here -->
                    @endif

                @endif
            </ul>

            <!-- Align logout to the right -->
            @if (Auth::check())
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Log out</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
