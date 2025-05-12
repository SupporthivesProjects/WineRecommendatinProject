@include('partials.mainhead')
<link rel="stylesheet" href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">


@stack('styles')
</head>

<body>

    @include("partials/switcher")
    @include("partials/loader")

    <div class="page">
        @include("partials/header")
        @include("partials/sidebar")
        

         @yield('admindashboardcontent')

        @include("partials/headersearch_modal")
        @include("partials/footer")
        @include("partials/right-sidebar")
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

        @include("partials/commonjs")

    <!-- JSVector Maps JS -->
    <script src="{{ asset('assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>    

    <!-- JSVector Maps MapsJS -->
    <script src="{{ asset('assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!-- Apex Charts JS -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Main-Dashboard -->
    <script src="{{ asset('assets/js/index.js') }}"></script>

     <!-- Chartjs Chart JS -->
     <script src="{{ asset('assets/libs/chart.js/chart.min.js') }}"></script>

    <!-- Imternal Chartjs JS -->
    <script src="{{ asset('assets/js/chartjs-charts.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Datatables Cdn -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- Internal Datatables JS -->
    <script src="{{ asset('assets/js/datatables.js') }}"></script>

     <!-- Toastr JS -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
     
    @stack('scripts')


    @include("partials/custom_switcherjs")

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

   
        <!-- Your existing content -->

        @if(auth()->check() && auth()->user()->role === 'user')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const sidebarToggle = document.querySelector('.sidemenu-toggle');
                    if (sidebarToggle) {
                        sidebarToggle.click(); // Auto-click to hide the sidebar
                    }
                });
            </script>
        @endif

</body>
</html>


    



</body>

</html>