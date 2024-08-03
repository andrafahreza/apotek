@extends('front.layouts.app')

@section('content')
<div class="shop-area">
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>  {{ $errors->first() }}
            </div>
        @endif

        @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Sukses!</strong>  {{ Session::get('success'); }}
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Pengaturan Profile</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile-admin-simpan') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Nama</label>
                                    <input class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label>Telepon</label>
                                    <input class="form-control" name="telepon" value="{{ Auth::user()->telepon }}" required>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label>Jenis Kelamin</label>
                                    <select class="form-control" name="jenis_kelamin" required>
                                        <option value="Laki-Laki" @if (Auth::user()->jenis_kelamin == "Laki-Laki") selected @endif>Laki-Laki</option>
                                        <option value="Perempuan" @if (Auth::user()->jenis_kelamin == "Perempuan") selected @endif>Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label>Alamat</label>
                                    <textarea class="form-control" name="alamat" required>{{ Auth::user()->alamat }}</textarea>
                                    <br>

                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Ganti Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('ganti-password') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="labels">Password Lama</label>
                                    <input type="password" name="old_password" class="form-control"
                                        placeholder="Masukkan Password Lama" required>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label class="labels">Password Baru</label>
                                    <input type="password" name="new_password" class="form-control"
                                        placeholder="Masukkan Passwoord baru" required>
                                </div>
                                <div class="col-md-12 mt-4">
                                    <label class="labels">Konfirmasi Password</label>
                                    <input type="password" name="konfirmasi_password" class="form-control"
                                        placeholder="Masukkan Passwoord baru" required>

                                    <br>
                                    <button class="btn btn-primary" type="submit">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
