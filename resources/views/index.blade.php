@extends('layouts.master')
@section('title')
    لوحة التحكم - برنامج الفواتير
@stop
@section('css')
    <!--  Owl-carousel css-->
    <link href="{{ URL::asset('assets/plugins/owl-carousel/owl.carousel.css') }}" rel="stylesheet" />
    <!-- Maps css -->
    <link href="{{ URL::asset('assets/plugins/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <style>
        .chart-container {
            display: flex;
            justify-content: space-around;
            /* لجعل الرسومات متباعدة بشكل متساوٍ */
            align-items: center;
            /* لضبط المحاذاة العمودية */
        }

        .chart-container canvas {
            max-width: 45%;
            /* لضبط حجم كل رسم بياني بحيث يتناسبان جنبًا إلى جنب */
        }

        #invoiceChart {
            display: block;
            height: 300px;
            width: 626px;
            /* تكبير حجم الدائرة */
        }

        #chart1 {
            max-width: 500px;
            max-height: 400px
                /* تصغير حجم الرسم البياني العمودي */
        }
    </style>
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <div>
                <h1>لوحة التحكم</h1>
            </div>
        </div>

    </div>
    <!-- /breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-primary-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">اجمالي الفواتير</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                    {{ number_format(\App\Models\invoices::sum('Total'), 2) }}
                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">{{ \App\Models\invoices::count() }}</p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7">100%</span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-danger-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير الغير مدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h3 class="tx-20 font-weight-bold mb-1 text-white">

                                    {{ number_format(\App\Models\invoices::where('Value_Status', 2)->sum('Total'), 2) }}

                                </h3>
                                <p class="mb-0 tx-12 text-white op-7">
                                    {{ \App\Models\invoices::where('Value_Status', 2)->count() }}
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7">

                                    @php
                                        $count_all = \App\Models\invoices::count();
                                        $count_invoices2 = \App\Models\invoices::where('Value_Status', 2)->count();

                                        if ($count_invoices2 == 0) {
                                            echo $count_invoices2 = 0;
                                        } else {
                                            echo round($count_invoices2 = ($count_invoices2 / $count_all) * 100) . '%';
                                        }
                                    @endphp

                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline2" class="pt-1">3,2,4,6,12,14,8,7,14,16,12,7,8,4,3,2,2,5,6,7</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-success-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                    {{ number_format(\App\Models\invoices::where('Value_Status', 1)->sum('Total'), 2) }}

                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">
                                    {{ \App\Models\invoices::where('Value_Status', 1)->count() }}
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-up text-white"></i>
                                <span class="text-white op-7">
                                    @php
                                        $count_all = \App\Models\invoices::count();
                                        $count_invoices1 = \App\Models\invoices::where('Value_Status', 1)->count();

                                        if ($count_invoices1 == 0) {
                                            echo $count_invoices1 = 0;
                                        } else {
                                            echo round($count_invoices1 = ($count_invoices1 / $count_all) * 100) . '%';
                                        }
                                    @endphp
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline3" class="pt-1">5,10,5,20,22,12,15,18,20,15,8,12,22,5,10,12,22,15,16,10</span>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
            <div class="card overflow-hidden sales-card bg-warning-gradient">
                <div class="pl-3 pt-3 pr-3 pb-2 pt-0">
                    <div class="">
                        <h6 class="mb-3 tx-12 text-white">الفواتير المدفوعة جزئيا</h6>
                    </div>
                    <div class="pb-0 mt-0">
                        <div class="d-flex">
                            <div class="">
                                <h4 class="tx-20 font-weight-bold mb-1 text-white">

                                    {{ number_format(\App\Models\invoices::where('Value_Status', 3)->sum('Total'), 2) }}

                                </h4>
                                <p class="mb-0 tx-12 text-white op-7">
                                    {{ \App\Models\invoices::where('Value_Status', 3)->count() }}
                                </p>
                            </div>
                            <span class="float-right my-auto mr-auto">
                                <i class="fas fa-arrow-circle-down text-white"></i>
                                <span class="text-white op-7">
                                    @php
                                        $count_all = \App\Models\invoices::count();
                                        $count_invoices1 = \App\Models\invoices::where(
                                            'Status',
                                            'مدفوعة جزئيا',
                                        )->count();

                                        if ($count_invoices1 == 0) {
                                            echo $count_invoices1 = 0;
                                        } else {
                                            echo round($count_invoices1 = ($count_invoices1 / $count_all) * 100) . '%';
                                        }
                                    @endphp
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
                <span id="compositeline4" class="pt-1">5,9,5,6,4,12,18,14,10,15,12,5,8,5,12,5,12,10,16,12</span>
            </div>
        </div>
    </div>
    <!-- row closed -->

    <!-- Chart Container -->
    <div class="chart-container">
        <canvas id="invoiceChart"></canvas>
        <canvas id="chart1"></canvas>
    </div>
    </div>
    </div>
    <!-- Container closed -->
@endsection
@section('js')
    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('invoiceChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie', // Use 'bar', 'doughnut', etc. if preferred
                data: {
                    labels: ['مدفوعة', 'مدفوعة جزئيا ', 'غير مدفوعة'],
                    datasets: [{
                        label: 'Invoice Statistics',
                        data: [
                            {{ $paidCount }},
                            {{ $partiallyPaidCount }},
                            {{ $unpaidCount }}
                        ],
                        backgroundColor: [
                            'rgba(50, 192, 50, 0.6)',
                            'rgba(255, 206, 86, 0.6)',
                            'rgba(255, 99, 132, 0.6)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        },
                        title: {
                            display: true,
                            text: 'Invoice Payment Status'
                        }
                    }
                }
            });
        });
    </script>








    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chart1').getContext('2d');
        const data = {
            labels: ['مدفوعة', 'مدفوعة جزئياً', 'غير مدفوعة'],
            datasets: [{
                label: 'النسبة المئوية للفواتير',
                data: [{{ $paidPercentage }}, {{ $partiallyPaidPercentage }}, {{ $unpaidPercentage }}],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)',
                ],
                borderWidth: 1,
            }]
        };

        const config = {
            type: 'bar', // يمكنك تغيير هذا إذا كنت ترغب في نوع آخر من الرسوم البيانية
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'النسبة المئوية'
                        }
                    }
                }
            }
        };

        const myChart = new Chart(ctx, config);
    </script>

    <!--Internal  Chart.bundle js -->
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <!-- Moment js -->
    <script src="{{ URL::asset('assets/plugins/raphael/raphael.min.js') }}"></script>
    <!--Internal  Flot js-->
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js') }}"></script>
    <script src="{{ URL::asset('assets/js/dashboard.sampledata.js') }}"></script>
    <script src="{{ URL::asset('assets/js/chart.flot.sampledata.js') }}"></script>
    <!--Internal Apexchart js-->
    <script src="{{ URL::asset('assets/js/apexcharts.js') }}"></script>
    <!-- Internal Map -->
    <script src="{{ URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ URL::asset('assets/js/modal-popup.js') }}"></script>
    <!--Internal  index js -->
    <script src="{{ URL::asset('assets/js/index.js') }}"></script>
    <script src="{{ URL::asset('assets/js/jquery.vmap.sampledata.js') }}"></script>
@endsection
