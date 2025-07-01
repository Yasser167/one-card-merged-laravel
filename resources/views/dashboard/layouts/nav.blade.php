<nav class="navbar navbar-dark bg-dark" style=" direction: ltr; ">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('index.dashboard') }}">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Admin</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{ route('index.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="{{ route('index.store') }}">WebSite</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link p-1" href="{{ route('index.settings') }}">settings</a>
                    </li>

                    <hr>

                    <li class="nav-item">
                        <a class="nav-link p-1" href="{{ route('admin.store.show') }}">Store</a>
                    </li>

                    <hr>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#." role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Others
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li class="border-bottom"><a class="nav-link p-1" href="{{ route('admin.settings') }}">settings Site</a></li>
                            <li class="border-bottom"><a class="nav-link p-1" href="{{ route('socialIcon.show') }}">social media Links</a></li>
                        </ul>
                    </li>

                    <hr>

                    <li class="nav-item dropdown">
                        <form action="{{ route('logout_user') }}" class="dropdown-item" method="POST">
                            @csrf
                            <button class="btn btn-secondary" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
