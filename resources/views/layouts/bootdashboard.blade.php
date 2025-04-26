@include('partials.mainhead')
<link rel="stylesheet" href="{{ asset('assets/libs/jsvectormap/css/jsvectormap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/libs/swiper/swiper-bundle.min.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
 <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

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


    <!-- Pie chart for wine types -->
    <script>
        const productTypeLabels = @json($productTypeLabels); 
        const productTypeData = @json($productTypeData); 

        const winetype = {
            labels: productTypeLabels,
            datasets: [{
                label: 'Wine Type Distribution',
                data: productTypeData,
                backgroundColor: [
                    'rgb(98, 89, 202)', // Color for Red Wine
                    'rgb(241, 56, 139)', // Color for White Wine
                    'rgb(0, 204, 204)', // Color for Rosé
                    'rgb(255, 159, 64)', // Color for Sparkling
                    // You can add more colors if needed based on data
                ],
                hoverOffset: 4
            }]
        };

        const winetypeconfig = {
            type: 'pie',
            data: winetype,
        };

        // Make sure the canvas element with id 'chartjs-pie' exists in your HTML
        const mywineChart = new Chart(
            document.getElementById('chartjs-pie'),
            winetypeconfig
        );
    </script>

    <!-- Bar chart for country wise   -->
    <script>
        /* Bar Chart */
        const countryCount = @json(count($countryLabels));  

        // Predefined color palette (same as your original template)
        const colorPaletteBackground = [
            'rgba(98, 89, 202, 0.2)', 'rgba(1, 184, 255, 0.2)', 'rgba(255, 155, 33, 0.2)',
            'rgba(0, 204, 204, 0.2)', 'rgba(253, 96, 116, 0.2)', 'rgba(25, 177, 89, 0.2)',
            'rgba(35, 35, 35, 0.2)'
        ];

        const colorPaletteBorder = [
            'rgb(98, 89, 202)', 'rgb(1, 184, 255)', 'rgb(255, 155, 33)',
            'rgb(0, 204, 204)', 'rgb(253, 96, 116)', 'rgb(25, 177, 89)',
            'rgb(35, 35, 35)'
        ];

        // Function to generate unique colors for each segment based on the template color palette
        function getColorForCountry(index) {
            return {
                backgroundColor: colorPaletteBackground[index % colorPaletteBackground.length],
                borderColor: colorPaletteBorder[index % colorPaletteBorder.length]
            };
        }

        const data33 = {
            labels: @json($countryLabels),  // Dynamically pass the country labels
            datasets: [{
                label: 'Wine Distribution by Country',
                data: @json($countryData),  // Dynamically pass the country counts
                backgroundColor: Array.from({ length: countryCount }, (v, i) => getColorForCountry(i).backgroundColor),
                borderColor: Array.from({ length: countryCount }, (v, i) => getColorForCountry(i).borderColor),
                borderWidth: 1,
                hoverOffset: 4
            }]
        };

        const config44 = {
            type: 'bar',
            data: data33,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        const mycountryChart = new Chart(
            document.getElementById('chartjs-bar'),
            config44
        );
    </script>




    <!-- Questionnaire Usage -->
    <script>
    var usageDates = @json($dates); 
    var usageCount = @json($counts);

    var options = {
        series: [{
            name: "Questionnaire Usage",
            data: usageCount // Use the dynamic usage count data
        }],
        chart: {
            height: 320,
            type: 'line',
            zoom: {
                enabled: false
            },
            dropShadow: {
                enabled: true,
                top: 5,
                left: 0,
                blur: 3,
                color: '#000',
                opacity: 0.1
            },
        },
        dataLabels: {
            enabled: false
        },
        legend: {
            position: "top",
            horizontalAlign: "center",
            offsetX: -15,
            fontWeight: "bold",
        },
        stroke: {
            curve: 'smooth',
            width: '3',
            dashArray: [0],
        },
        grid: {
            borderColor: '#f2f6f7',
        },
        colors: ["rgb(98, 89, 202)"],
        yaxis: {
            title: {
                text: '',
                style: {
                    color: '#adb5be',
                    fontSize: '14px',
                    fontFamily: 'poppins, sans-serif',
                    fontWeight: 600,
                    cssClass: 'apexcharts-yaxis-label',
                },
            },
            min: 0,  // Start the y-axis from 0
            tickAmount: Math.max(...usageCount), // Dynamically set the max ticks based on the data
            labels: {
                formatter: function (value) {
                    return Math.round(value); // Ensure values are rounded and integers
                }
            }
        },
        xaxis: {
            type: 'category',  // This is for categorical data like days
            categories: usageDates,  // Use the dates fetched from the database
            axisBorder: {
                show: false,
                color: 'rgba(119, 119, 142, 0.05)',
                offsetX: 0,
                offsetY: 0,
            },
            axisTicks: {
                show: true,
                borderType: 'solid',
                color: 'rgba(119, 119, 142, 0.05)',
                width: 6,
                offsetX: 0,
                offsetY: 0
            },
            labels: {
                rotate: -45  // Rotate labels if they are too long
            }
        }
    };

    document.getElementById('project').innerHTML = '';
    var chart23 = new ApexCharts(document.querySelector("#project"), options);
    chart23.render();
</script>




    @include("partials/custom_switcherjs")

    <!-- Custom JS -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>

</body>

</html>