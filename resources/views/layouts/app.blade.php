<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
    <link rel="stylesheet" href="../../vendors/select2/select2.min.css">
    <link rel="stylesheet" href="../../vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/favicon.png" />
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

    <script src="vendors/base/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/template.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <!-- End plugin js for this page -->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/progressbar.js/progressbar.min.js"></script>
    <script src="vendors/chartjs-plugin-datalabels/chartjs-plugin-datalabels.js"></script>
    <script src="vendors/justgage/raphael-2.1.4.min.js"></script>
    <script src="vendors/justgage/justgage.js"></script>
    <script src="js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../../vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="../../vendors/select2/select2.min.js"></script>
    <script src="../../js/file-upload.js"></script>
    <script src="../../js/typeahead.js"></script>
    <script src="../../js/select2.js"></script>
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <!-- End custom js for this page-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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