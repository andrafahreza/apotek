<div class="container-fluid g-0">
    <div class="row">
        <div class="col-lg-12 p-0">
            <div class="header_iner d-flex justify-content-between align-items-center">
                <div class="sidebar_icon d-lg-none">
                    <i class="ti-menu"></i>
                </div>
                <div class="serach_field-area"></div>
                <div class="header_right d-flex justify-content-between align-items-center">
                    <div class="profile_info">
                        <img src="/back/user.png" alt="#">
                        <div class="profile_info_iner">
                            <p>{{ strtoupper(Auth::user()->role) }}</p>
                            <h5>{{ Auth::user()->name }}</h5>
                            <div class="profile_info_details">
                                <a href="#">My Profile <i class="ti-user"></i></a>
                                <a href="{{ route('logout') }}">Log Out <i class="ti-shift-left"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
