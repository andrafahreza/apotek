@extends('back.layouts.app')

@section('content')
    <div class="col-12">
        <div class="QA_section">
            <div class="white_box_tittle list_header">
                <h4>Data Persediaan Obat</h4>
                <div class="box_right d-flex lms_block">
                    <div class="serach_field_2">
                        <div class="search_inner">
                            {{-- <div class="search_field">
                                <input id="search" type="text" placeholder="Cari...">
                            </div>
                            <button type="button" id="btnSearch"> <i class="ti-search"></i> </button> --}}
                        </div>
                    </div>
                    <div class="add_button ms-2">
                        <a class="btn_1" href="{{ route('pembelian') }}">+ Beli Stok</a>
                    </div>
                </div>
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
                <table class="table lms_table_active">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Nama Obat</th>
                            <th scope="col">Jumlah Obat</th>
                            <th scope="col">Tgl Masuk</th>
                            <th scope="col">Tgl Kadaluarsa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data->stok as $item)
                            <tr>
                                <th scope="row">#{{ $item->id }}</th>
                                <td>{{ $data->nama_obat }}</td>
                                <td>{{ $item->jumlah_obat }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->tgl_masuk)) }}</td>
                                <td>{{ date('d-m-Y', strtotime($item->tgl_kadaluarsa)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#btnSearch').on('click', function() {
            var search = $('#search').val();
            var url = "{{ route('obat') }}" + "/" + search;
            window.location = url;
        })
    </script>
@endpush
