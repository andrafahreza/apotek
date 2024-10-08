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

            <div class="row content-justify-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header"><h1>Pengisian Alamat</h1></div>
                        <div class="card-body">
                            <div class="zoom-containt">
                                <div class="zoom-containt-bottom">
                                    <div class="re-form">
                                        <form action="{{ route('pengisian-alamat', ['id' => $id]) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="keranjang_id" value="{{ $keranjang->id }}">
                                            <div class="single-re-input">
                                                <label for="alamat">Alamat*</label>
                                                <textarea class="form-control" name="alamat" required></textarea>
                                            </div>
                                            <button class="team-1" type="submit">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
