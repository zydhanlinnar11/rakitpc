@extends('layouts.app')

@section('main-content')
<x-_content_container :pageTitle="'Edit Profil'">
    <x-_admin_form_alert />
    <form action="javascript:getToken(editProfile, '{{csrf_token()}}')" id="informasi-umum" class="mb-3">
        @csrf
        <div class="form-group mb-3">
            <label for="name" class="col-md-4 col-form-label text-md-right">Nama :</label>
            <input class="form-control" id="name" placeholder="Nama" type="text" name="name"
            value="{{$user['name']}}"
            required autofocus>
        </div>

        <div class="form-group mb-3">
            <label for="email" class="col-md-4 col-form-label text-md-right">E-mail :</label>
            <input class="form-control" id="email" placeholder="E-mail" type="email"
            value="{{$user['email']}}"
            required>
        </div>

        <div class="form-group mb-3">
            <label for="telp" class="col-md-4 col-form-label text-md-right">Nomor telepon :</label>
            <input class="form-control" id="telp" placeholder="Nomor telepon" type="telp"
            value="{{$user['no_telp']}}" pattern="[0-9]+"
            required>
        </div>

        <div class="row">
            <div class="col-12 mb-5">
                <button class="btn btn-primary col-12" type="submit" class="btn btn-primary">
                    Edit
                </button>
            </div>
        </div>
    </form>
</x-_content_container>

<script>
    function editProfile(token) {
      const name = document.getElementById("name").value;
      const email = document.getElementById("email").value;
      const no_telp = document.getElementById("telp").value;

      ajax.open("PATCH", "{{route('user.patch-edit-profile')}}", true);

      closeAlert();
      ajax.setRequestHeader("Content-Type", "application/json");
      ajax.setRequestHeader("Authorization", `Bearer ${token}`)
      ajax.send(JSON.stringify({ name, email, no_telp }));
    }
</script>
@endsection