@extends('layouts.app')

@section('main-content')
<div class="card-container">
    <h1 class="card-container-title">Kategori</h1>
    <hr>
    <div class="row">
        <?php 
            $list_kategori = array(
                "AMD Ryzen 3 3100",
                "AMD Ryzen 3 3300X",
                "AMD Ryzen 3 3200G",
                "AMD Ryzen 5 3400G",
                "AMD Ryzen 5 3600",
                "AMD Ryzen 5 3600X",
                "AMD Ryzen 5 3600XT",
                "AMD Ryzen 5 5600X",
                "AMD Ryzen 7 3700X",
                "Intel Core i3-10100F",
                "Intel Core i5-10400F",
            );
        ?> 

        @foreach ($list_kategori as $key)
            <div class="col-xxl-1 col-xl-2 col-lg-3 col-md-4 col-sm-6">
                <div class="card text-center col-12" style="margin-bottom: 16px">
                    <img src="https://storage.googleapis.com/zydhan-web.appspot.com/gambar-biner.webp" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $key ?></h5>
                            <a href="#" class="btn btn-primary">Belanja</a>
                        </div>
                    </div>
            </div>
        @endforeach
    </div>
</div>
@endsection