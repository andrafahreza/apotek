<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Login</title>
    <link rel="icon" href="/front/assets/logo.png" type="image/png">
    <link rel="stylesheet" href="/back/css/bootstrap1.min.css" />
    <link rel="stylesheet" href="/back/vendors/themefy_icon/themify-icons.css" />
    <link rel="stylesheet" href="/back/vendors/font_awesome/css/all.min.css" />
    <link rel="stylesheet" href="/back/vendors/material_icon/material-icons.css" />
    <link rel="stylesheet" href="/back/css/style1.css" />
</head>

<body class="crm_body_bg">
    <div class="main_content_iner ">
        <div class="container-fluid p-0">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 mt-5">
                            <div class="modal-content cs_modal">
                                <div class="modal-header">
                                    <h5 class="modal-title">Log in</h5>
                                </div>
                                <div class="modal-body">
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

                                    <form action="{{ route('auth') }}" method="POST">
                                        @csrf
                                        <input name="email" type="text" class="form-control" placeholder="Email" required>
                                        <input name="password" type="password" class="form-control" placeholder="Password" required>
                                        <button class="btn_1 full_width text-center" type="submit">Log in</button>
                                        <p>Belum punya akun? <a data-bs-toggle="modal" data-bs-target="#sing_up" data-bs-dismiss="modal" href="{{ route('register') }}"> Daftar</a></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
