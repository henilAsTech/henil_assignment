<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- DataTables CSS --}}
    <link rel="stylesheet"
          href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>

        body{
            background-color:#f5f7fb;
        }

        .navbar-brand{
            font-weight:700;
            letter-spacing:1px;
        }

        .card{
            border:none;
            border-radius:12px;
            box-shadow:0 2px 10px rgba(0,0,0,0.08);
        }

        .table thead{
            background:#0d6efd;
            color:white;
        }

        .btn{
            border-radius:8px;
        }

        .dataTables_wrapper .dataTables_filter input{
            border-radius:8px;
            border:1px solid #ced4da;
            padding:6px 10px;
        }

        .dataTables_wrapper .dataTables_length select{
            border-radius:8px;
            border:1px solid #ced4da;
            padding:5px;
        }

        .profile-image{
            width:60px;
            height:60px;
            object-fit:cover;
            border-radius:50%;
            border:2px solid #dee2e6;
        }

        .modal-content{
            border-radius:14px;
        }

    </style>

    @yield('styles')

</head>

<body>


    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

        <div class="container">

            <a class="navbar-brand"
               href="#">

                Family Management

            </a>

        </div>

    </nav>



    {{-- Main Content --}}
    <main class="py-4">

        <div class="container">

            @if(session('success'))

                <div class="alert alert-success alert-dismissible fade show">

                    {{ session('success') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">

                    </button>

                </div>

            @endif


            @if(session('error'))

                <div class="alert alert-danger alert-dismissible fade show">

                    {{ session('error') }}

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert">

                    </button>

                </div>

            @endif


            @yield('content')

        </div>

    </main>



    {{-- JQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Datatable JS --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    @yield('scripts')

</body>

</html>