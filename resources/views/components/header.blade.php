<header>
    <h1 id='main-title'>RakitPC</h1>
    <nav>
        <button class="nav-button" id="nav-button-home">Home</button>
        <div class="nav-vertical-divider"></div>
        <button class="nav-button" id="nav-button-simulasi">Simulasi</button>
        <div class="nav-vertical-divider"></div>
        @if (Auth::check())
        <button onclick="window.open('{{route('logout')}}', '_self')" class="nav-button" id="nav-button-admin">Log out</button>
        @else
        <button onclick="window.open('{{route('login')}}', '_self')" class="nav-button" id="nav-button-admin">Login</button>
        @endif
    </nav>
</header>