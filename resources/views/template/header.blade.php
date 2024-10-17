<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid flex-column align-items-center">
        <!-- Navbar Brand - Centered Above the Collapse -->
        <a class="navbar-brand" href="/">
            <img src="https://i.ibb.co/XydNNvZ/Logo-Maker-Ca-1728976782332-Copy.png" alt="Logo" style="height: 100px;">
        </a>

        <!-- Navbar Toggler (Visible on smaller screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Collapse -->
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="/">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="/about">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="/about">Publications</a>
                </li>

                {{-- checks if user is logged in or not --}}
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="/profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Logout</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="/login">Login</a>
                    </li>
                @endif
            </ul>

            
        </div>
    </div>
</nav>
