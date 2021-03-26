<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RakitPC</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1 id='main-title'>RakitPC</h1>
        <nav>
            <button class="nav-button">How-to</button>
            <div class="nav-vertical-divider"></div>
            <button class="nav-button">Simulasi</button>
        </nav>
    </header>

    <main>
        <div class="card-container">
            <h1 class="card-container-title">Kategori</h1>
            <hr>
            <div class="row">
                <?php 
                    $list_kategori = array("Prosesor", "Motherboard", "Memori RAM", "SSD", "Power Supply", "Casing");
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
    </main>
    
    <footer>
      <div id="horizontal-bar"></div>
      <div id="footer-container">
        <h6 class="footer-text">RakitPC by Zydhan</h6>
        <div id="vertical-bar"></div>
        <h6 class="footer-text">Created using Laravel</h6>
      </div>
    </footer>
</body>
</html>