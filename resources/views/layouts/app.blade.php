<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/base/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/select.dataTables.min.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    @yield('header')
  </head>
  <body>
    <div class="container-scroller">
        @include('layouts.partials.menu')
        <div class="container-fluid page-body-wrapper">
            <div class="main-panel">
                @yield('content')
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('vendors/base/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('js/template.js') }}"></script>
    <script src="{{ asset('vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js') }}"></script>
    <script src="{{ asset('vendors/justgage/raphael-2.1.4.min.js') }}"></script>
    <script src="{{ asset('vendors/justgage/justgage.js') }}"></script>
    <script src="{{ asset('js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/file-upload.js') }}"></script>
    <script src="{{ asset('js/typeahead.js') }}"></script>
    <script src="{{ asset('js/select2.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        })
        @if (Session::has('sweetalert') && Session::has('alert'))
        Toast.fire({
            icon: "{{ Session::get('sweetalert') }}",
            title: "{{ Session::get('alert') }}"
        })
        @endif
        // LogOut
        @if (Session::has('logout'))
        Toast.fire({
            icon: 'success',
            title: "{{ Session::get('logout') }}"
        })
        @endif

        $(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                showArrows: false,
            });
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        function updateScreenSize() {
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            if(viewportWidth <= 991){
                let bodyBefore = $('#body-before');
                let bodyAfter = $('#body-after');

                bodyBefore.removeClass('col-sm-2');
                bodyAfter.removeClass('col-sm-10');
            }
        }

            // Call the function on page load and whenever the window is resized
        window.onload = updateScreenSize;
        window.addEventListener("resize", updateScreenSize);

        $.fn.dataTable.ext.errMode = 'none';
    </script>
    @yield('footer')
  </body>
</html>