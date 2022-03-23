
<div class="card-container">
    <h1 class="card-container-title">
        <a href="{{isset($href) ? $href : 'javascript:history.back()'}}" class="fas fa-arrow-left" style="text-decoration: none; color: #212529"></a>
        {{$pageTitle}}
    </h1>
    <hr>
    {{ $slot }}
</div>