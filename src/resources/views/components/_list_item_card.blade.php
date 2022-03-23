<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
    <div class="card text-center col-12" style="margin-bottom: 16px">
        <div class="text-center card-img-top mt-1">
            <img src="{{$key->url_gambar}}"
            alt="Gambar dari {{$key->nama}}" style="max-height: 120px; max-width: 100%">
        </div>
            <div class="card-body">
                <h5 class="card-title">{{$key->nama}}</h5>
                {{$button1}}
                @isset($button2)
                    {{$button2}}
                @endisset
                @isset($button3)
                    {{$button3}}
                @endisset
            </div>
        </div>
</div>