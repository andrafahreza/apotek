@extends('back.layouts.app')

@section('content')
    <div class="col-lg-12">
        <div class="single_element">
            <div class="quick_activity">
                <div class="row">
                    <div class="col-12">
                        <div class="quick_activity_wrap">
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/man.svg" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($customer->count()) }}</span></h3>
                                    <p>Customer</p>
                                </div>
                            </div>
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/cap.svg" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($obat->count()) }}</span></h3>
                                    <p>Obat</p>
                                </div>
                            </div>
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/transaction.png" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($penjualan->count()) }}</span></h3>
                                    <p>Penjualan</p>
                                </div>
                            </div>
                            <div class="single_quick_activity d-flex">
                                <div class="icon">
                                    <img src="/back/img/icon/pharma.svg" alt />
                                </div>
                                <div class="count_content">
                                    <h3><span class="counter">{{ number_format($pemasok->count()) }}</span></h3>
                                    <p>Pemasok</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
