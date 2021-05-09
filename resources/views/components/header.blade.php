<header>
    <h1 id='main-title'>RakitPC</h1>
    <nav>
        <button class="nav-button" id="nav-button-home">Home</button>
        <div class="nav-vertical-divider"></div>
        <button class="nav-button" id="nav-button-simulasi">Simulasi</button>
        @if (Auth::check())
        @if (Gate::allows('access-admin'))
        <div class="nav-vertical-divider"></div>
        <button onclick="window.open('{{route('admin.dashboard')}}', '_self')" class="nav-button" id="nav-button-admin">Admin</button>
        @endif
        <div class="nav-vertical-divider"></div>
        <button onclick="window.open('{{route('user.profile')}}', '_self')" class="nav-button" id="nav-button-profile">Profil</button>
        <div class="nav-vertical-divider"></div>
        <button onclick="window.open('{{route('user.keranjang')}}', '_self')" class="nav-button" id="nav-button-cart">Keranjang</button>
        <div class="nav-vertical-divider"></div>
        <button onclick="window.open('{{route('logout')}}', '_self')" class="nav-button" id="nav-button-logout">Log out</button>
        @else
        <div class="nav-vertical-divider"></div>
        <button onclick="window.open('{{route('login')}}', '_self')" class="nav-button" id="nav-button-login">Login</button>
        @endif
    </nav>
</header>