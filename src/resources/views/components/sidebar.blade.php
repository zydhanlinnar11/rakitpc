<div onclick="onClickShadow(event)" id="side-bar-block">
    <div class="shadow-lg" id="side-bar">
        <button onclick="window.open('/', '_self')" class="side-button" id="side-button-home">Home</button>
        <div class="side-horizontal-divider"></div>
        <button onclick="window.open('{{route('simulasi')}}', '_self')" class="side-button" id="side-button-simulasi">Simulasi</button>
        @if (Auth::check())
        @if (Gate::allows('access-admin'))
        <div class="side-horizontal-divider"></div>
        <button onclick="window.open('{{route('admin.dashboard')}}', '_self')" class="side-button" id="side-button-admin">Admin</button>
        @endif
        <div class="side-horizontal-divider"></div>
        <button onclick="window.open('{{route('user.profile')}}', '_self')" class="side-button" id="side-button-profile">Profil</button>
        <div class="side-horizontal-divider"></div>
        <button onclick="window.open('{{route('user.keranjang')}}', '_self')" class="side-button" id="side-button-cart">Keranjang</button>
        <div class="side-horizontal-divider"></div>
        <button onclick="window.open('{{route('logout')}}', '_self')" class="side-button" id="side-button-logout">Log out</button>
        @else
        <div class="side-horizontal-divider"></div>
        <button onclick="window.open('{{route('auth.google.redirect')}}', '_self')" class="side-button" id="side-button-login">Login</button>
        @endif
    </div>
</div>