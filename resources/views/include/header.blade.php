<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- <script src="{{ asset('js/axios.min.js') }}"></script> -->
    <!-- <script src="{{ asset('js/webfont.js') }}"></script> -->
    <!-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script> -->

    <link rel="icon" type="image/png" href="/favicon.ico">
    <title>API - Advocacia Alves Bezerra</title>

</head>

<body>
    <div id="overlay" class="overlay"></div>
    <div id="loader" class="loader"></div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a id="home" class="navbar-brand d-flex align-items-center" href="{{ env('APP_URL') }}">
                <img src="{{ asset('images/Icon.png') }}" alt="Logo" style="height: 50px; border-radius: 25px; object-fit: cover; margin-right: 10px;" />
                API - Advocacia Alves Bezerra
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-5 mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item">
                        <button id="documentacao" class="nav-link active" aria-current="page" onclick="alertaDocumentacao()">Documentação</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="position-fixed top-5 end-0 p-3" style="z-index: 999">
        <div id="toast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto">Aviso</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Fechar"></button>
            </div>
            <div class="toast-body">
            </div>
        </div>
    </div>

    @if(session('success'))
    <script>
        $(document).ready(function() {
            $('#toast .toast-body').html("{{ session('success') }}");
            $('#toast').addClass('bg-light');
            var toast = new bootstrap.Toast($('#toast'));
            toast.show();
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        $(document).ready(function() {
            $('#toast .toast-body').html("{{ session('error') }}");
            $('#toast').addClass('bg-warning');
            var toast = new bootstrap.Toast($('#toast'));
            toast.show();
        });
    </script>
    @endif

    <script>
        function alertaDocumentacao() {
            alert('Em desenvolvimento');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#login').submit(function() {
                $('#overlay').show();
                $('#loader').show();
            });
            $('#home').click(function() {
                $('#overlay').show();
                $('#loader').show();
            });
        });
    </script>