<style>
    .dropdown-item:focus {
        background-color: transparent !important;
    }
    .toggle-btn {
        background: none;
        border: none;
        cursor: pointer;
        perspective: 600px;
    }
    .flip-container {
        width: 40px;
        height: 40px;
    }
    .flipper {
        transition: transform 0.6s;
        transform-style: preserve-3d;
        position: relative;
        width: 100%;
        height: 100%;
    }
    .toggle-btn.flipped .flipper {
        transform: rotateY(180deg);
    }
    .front, .back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .back {
        transform: rotateY(180deg);
    }
</style>

<aside id="sidebar">
    <div class="d-flex">
        <button class="toggle-btn" type="button">
            <div class="flip-container">
                <div class="flipper">
                <div class="front">
                    <i class="fas fa-dove"></i>
                </div>
                <div class="back">
                    <i class="fas fa-dove"></i>
                </div>
                </div>
            </div>
        </button>
        <div class="sidebar-logo">
            <h6><span>Glaçons Friouato</span></h6>
        </div>
    </div>
    <ul class="sidebar-nav">
        @if (auth()->user()->role === 'admin')
            <li class="sidebar-item">
                <a href="{{ route('fiscs.index') }}" class="sidebar-link">
                    <i class="fas fa-shop"></i>
                    <span>Caisse</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('clients.index') }}" class="sidebar-link">
                    <i class="fas fa-handshake"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('users.index') }}" class="sidebar-link">
                    <i class="fas fa-user-shield"></i>
                    <span>Employés</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('deliveries.index') }}" class="sidebar-link">
                    <i class="fas fa-truck"></i>
                    <span>Livraisons</span>
                </a>
            </li>
        @endif
        <li class="sidebar-item">
            <a href="{{ auth()->user()->role === 'admin' ? route('worklogs.index') : route('worklogs.overview', auth()->id()) }}" class="sidebar-link">
                <i class="fas fa-clock"></i>
                <span>Feuilles de temps</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ auth()->user()->role === 'admin' ? route('icecubes.index') : route('icecubes.logs', auth()->id()) }}" class="sidebar-link">
                <i class="fas fa-snowflake"></i>
                <span>Production de glaçons</span>
            </a>
        </li>
    </ul>
    <div class="sidebar-footer">
        <div class="sidebar-item">
            <a href="{{ route('users.profile', auth()->id()) }}" class="sidebar-link">
                <i class="fas fa-user"></i>
                <span>Profil</span>
            </a>
        </div>
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('defaults.index') }}" class="sidebar-link">
                <i class="fas fa-sliders-h"></i>
                <span>Réglages</span>
            </a>
        @endif
        <a href="{{ route('logout') }}" class="sidebar-link">
            <i class="fas fa-sign-out-alt"></i>
            <span>Déconnexion</span>
        </a>
    </div>
</aside>

<div class="main w-100">
    <nav class="navbar navbar-expand px-4 py-3 bg-white shadow-sm">
        <div class="container-fluid">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item dropdown">
                    <a data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                        <i class="fas fa-user text-dark" style="color: #344264 !important; font-size: 1.4em; cursor:pointer;"></i>
                    </a>
                    <ul class="dropdown-menu text-center dropdown-menu-end rounded border-0 shadow px-2 py-2" aria-labelledby="profile-dropdown" style="min-width: 200px !important;">
                        <li style="cursor: default;">
                            <div class="rounded-3 bg-light mb-3" style="padding: 12px;">
                                <i class="fas fa-user" style="font-size: 1.2em; color: #344264;"></i>
                            </div>
                            <h6 style="color: #344264; letter-spacing: 0.75px;">{{ auth()->user()->name }}</h6>
                        </li>
                        <li><hr class="dropdown-divider" style="border-width: 2px; border-color: #eee;" /></li>
                        <li><a style="font-weight: 500; letter-spacing: 0.75px;" class="dropdown-item text-secondary py-2" href="{{ route('users.profile', auth()->id()) }}">Profil</a></li>
                        <li><a style="font-weight: 500; letter-spacing: 0.75px;" class="dropdown-item text-secondary py-2" href="{{ route('logout') }}">Déconnexion</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
