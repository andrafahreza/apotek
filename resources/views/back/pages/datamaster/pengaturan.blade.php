@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Pengaturan</h4>
            </div>
            <div class="QA_table mb_30">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong>  {{ $errors->first() }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Sukses!</strong>  {{ Session::get('success'); }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <form action="{{ route('pengaturan-simpan') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Nama Apotek</label>
                                            <input class="form-control" name="nama" value="@if (!empty($data)) {{ $data->nama }} @endif" required>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label>Alamat</label>
                                            <input class="form-control" name="alamat" value="@if (!empty($data)) {{ $data->alamat }} @endif" required>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label>Link Map</label>
                                            <input class="form-control" name="map" value="@if (!empty($data)) {{ $data->map }} @endif" required>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label>Telepon</label>
                                            <input class="form-control" name="telepon" value="@if (!empty($data)) {{ $data->telepon }} @endif" required>
                                        </div>
                                        <div class="col-md-6 mt-4">
                                            <label>Nama Kontak</label>
                                            <input class="form-control" name="nama_kontak" value="@if (!empty($data)) {{ $data->nama_kontak }} @endif" required>
                                        </div>
                                        <div class="col-md-12 mt-4">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" value="@if (!empty($data)) {{ $data->email }} @endif" required>
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
    </div>
@endsection
