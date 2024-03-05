@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row {{ Auth::user()->roles[0]->name != 'Zisco' ? '' : 'd-none' }}">
            <div class="col-lg-3 col-md-4">
                <x-info-box infoTitle="Total Users" infoIcon="fas fa-users" infoId="totaluser" infoColor="bg-warning">
                </x-info-box>
            </div>
            <div class="col-lg-3 col-md-4">
                <x-info-box infoTitle="Total Categories" infoIcon="fas fa-list" infoId="totalcategories" infoColor="bg-info"></x-info-box>
            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-lg-3 col-md-4">
                <x-info-box infoTitle="Total Campaigns" infoIcon="fas fa-newspaper" infoId="totalcampaigns" infoColor="bg-primary"></x-info-box>
            </div>
            <div class="col-lg-3 col-md-4">
                <x-info-box infoTitle="Total Transaksi" infoIcon="fas fa-shopping-cart" infoId="totaldonations" infoColor="bg-success"></x-info-box>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        Trafik Analisis Donasi
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-body row">
                                        <div class="col-lg-4">
                                            <label>Tanggal</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control daterange float-right" id="filter_date_a">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8" id="graph1">
                                <canvas id="statistikdonasi"></canvas>
                            </div>
                            <div class="col-lg-4">
                                <x-info-box infoTitle="Total Transaksi" infoIcon="fas fa-shopping-cart" infoId="totaltransaksi" infoColor="bg-info"></x-info-box>
                                <x-info-box infoTitle="Transaksi Pending" infoIcon="fas fa-shopping-cart" infoId="totaltransaksipending" infoColor="bg-warning"></x-info-box>
                                <x-info-box infoTitle="Transaksi Expired" infoIcon="fas fa-shopping-cart" infoId="totaltransaksiexpired" infoColor="bg-danger"></x-info-box>
                                <x-info-box infoTitle="Transaksi Success" infoIcon="fas fa-shopping-cart" infoId="totaltransaksisuccess" infoColor="bg-success"></x-info-box>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        Trafik Analisis Donatur
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card card-primary card-outline">
                                    <div class="card-body row">
                                        <div class="col-lg-4">
                                            <label>Tanggal</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control daterange float-right" id="filter_date_b">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8" id="graph1">
                                <canvas id="statistiktransaksi"></canvas>
                            </div>
                            <div class="col-lg-4">
                                <x-info-box infoTitle="Total Transaksi" infoIcon="fas fa-shopping-cart" infoId="counttransaksi" infoColor=" bg-warning"></x-info-box>
                                <x-info-box infoTitle="Transaksi Pending" infoIcon="fas fa-shopping-cart" infoId="counttransaksipending" infoColor="bg-warning"></x-info-box>
                                <x-info-box infoTitle="Transaksi Expired" infoIcon="fas fa-shopping-cart" infoId="counttransaksiexpired" infoColor="bg-danger"></x-info-box>
                                <x-info-box infoTitle="Transaksi Success" infoIcon="fas fa-shopping-cart" infoId="counttransaksisuccess" infoColor="bg-success"></x-info-box>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row {{ Auth::user()->roles[0]->name != 'Zisco' ? '' : 'd-none' }}">
            <div class="col-lg-12">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <span>
                            <span>PHP Version: </span> <span class="font-weight-bold">v{{ PHP_VERSION }}</span>
                        </span>
                        <br />
                        <span>
                            <span>Laravel Version</span> <span class="font-weight-bold">v{{ Illuminate\Foundation\Application::VERSION }}</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(Auth::user()->roles[0]->name != 'Zisco')
<script type="module">
    $(document).ready(function() {

        ajaxRequest({
            url: `/apis/users`,
        }).done((users) => {
            setTextValue('#totaluser', users.data.length)
        })

        ajaxRequest({
            url: `/apis/categories`,
        }).done((categories) => {
            setTextValue('#totalcategories', categories.data.length)
        })

        ajaxRequest({
            url: `/apis/campaigns`,
        }).done((campaigns) => {
            setTextValue('#totalcampaigns', campaigns.data.length)
        })

        ajaxRequest({
            url: `/apis/donations`,
        }).done((donations) => {
            setTextValue('#totaldonations', donations.data.length)
        })

    });
</script>
@endif

<script type="module">
    $(document).ready(function() {
        setDateRange({
            idtag: '#filter_date_a'
        })

        setDateRange({
            idtag: '#filter_date_b'
        })

        var tanggalFilterAMulai = $('#filter_date_a').data().startDate.format('YYYY-MM-DD')
        var tanggalFilterAAkhir = $('#filter_date_a').data().endDate.format('YYYY-MM-DD')
        var labelA = getDates(tanggalFilterAMulai, tanggalFilterAAkhir)

        var tanggalFilterBMulai = $('#filter_date_b').data().startDate.format('YYYY-MM-DD')
        var tanggalFilterBAkhir = $('#filter_date_b').data().endDate.format('YYYY-MM-DD')
        var labelB = getDates(tanggalFilterBMulai, tanggalFilterBAkhir)

        getTotalNominalByStatus(tanggalFilterAMulai, tanggalFilterAAkhir)
        getTotalCountByStatus(tanggalFilterBMulai, tanggalFilterBAkhir)

        $('#filter_date_a').on('apply.daterangepicker', function(ev, picker) {
            tanggalFilterAMulai = picker.startDate.format('YYYY-MM-DD')
            tanggalFilterAAkhir = picker.endDate.format('YYYY-MM-DD')
            labelA = getDates(tanggalFilterAMulai, tanggalFilterAAkhir)

            getTotalNominalByStatus(tanggalFilterAMulai, tanggalFilterAAkhir)
        });

        $('#filter_date_b').on('apply.daterangepicker', function(ev, picker) {
            tanggalFilterBMulai = picker.startDate.format('YYYY-MM-DD')
            tanggalFilterBAkhir = picker.endDate.format('YYYY-MM-DD')
            labelB = getDates(tanggalFilterBMulai, tanggalFilterBAkhir)

            getTotalCountByStatus(tanggalFilterBMulai, tanggalFilterBAkhir)
        });

        var chartOptions = {
            scales: {
                y: {
                    min: 0,
                }
            },
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear',
                    from: 1,
                    to: 0,
                    loop: true
                }
            },
            plugins: {
                colors: {
                    enabled: true
                }
            }
        }

        var statistikDonasiChart = new Chart(
            $('#statistikdonasi'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                            label: 'All',
                            data: [],
                        }, {
                            label: 'Pending',
                            data: [],
                        },
                        {
                            label: 'Expired',
                            data: [],
                        },
                        {
                            label: 'Success',
                            data: [],
                        }
                    ]
                },
                options: chartOptions
            }
        );

        var statistikTransaksiChart = new Chart(
            $('#statistiktransaksi'), {
                type: 'line',
                data: {
                    labels: [],
                    datasets: [{
                            label: 'All',
                            data: [],
                        }, {
                            label: 'Pending',
                            data: [],
                        },
                        {
                            label: 'Expired',
                            data: [],
                        },
                        {
                            label: 'Success',
                            data: [],
                        }
                    ]
                },
                options: chartOptions
            }
        );

        function getTotalNominalByStatus(startDate, endDate) {
            ajaxRequest({
                url: `/apis/donations/getTotalNominalByStatus`,
                type: 'POST',
                params: {
                    startDate: startDate,
                    endDate: endDate,
                    referals: '{{ Auth()->user()->referals }}'
                },
            }).done((result) => {
                setTextValue('#totaltransaksipending', formatRupiah(result.data.nominal_pending))
                setTextValue('#totaltransaksiexpired', formatRupiah(result.data.nominal_expired))
                setTextValue('#totaltransaksisuccess', formatRupiah(result.data.nominal_success))
                setTextValue('#totaltransaksi', formatRupiah(parseInt(result.data.nominal_success) + parseInt(result.data.nominal_pending) + parseInt(result.data.nominal_expired)))

                statistikDonasiChart.clear()
                statistikDonasiChart.data.labels = labelA;
                statistikDonasiChart.data.datasets[0].data = result.data.nominalGroupByDate
                statistikDonasiChart.data.datasets[1].data = result.data.nominal_pending_array
                statistikDonasiChart.data.datasets[2].data = result.data.nominal_expired_array
                statistikDonasiChart.data.datasets[3].data = result.data.nominal_success_array
                statistikDonasiChart.update();
            })
        }

        function getTotalCountByStatus(startDate, endDate) {
            ajaxRequest({
                url: `/apis/donations/getTotalCountByStatus`,
                type: 'POST',
                params: {
                    startDate: startDate,
                    endDate: endDate,
                    referals: '{{ Auth()->user()->referals }}'
                },
            }).done((result) => {
                setTextValue('#counttransaksipending', result.data.count_pending)
                setTextValue('#counttransaksiexpired', result.data.count_expired)
                setTextValue('#counttransaksisuccess', result.data.count_success)
                setTextValue('#counttransaksi', (result.data.count_success + result.data.count_pending + result.data.count_expired))

                statistikTransaksiChart.clear()
                statistikTransaksiChart.data.labels = labelB;
                statistikTransaksiChart.data.datasets[0].data = result.data.countGroupByDate
                statistikTransaksiChart.data.datasets[1].data = result.data.count_pending_array
                statistikTransaksiChart.data.datasets[2].data = result.data.count_expired_array
                statistikTransaksiChart.data.datasets[3].data = result.data.count_success_array
                statistikTransaksiChart.update();
            })
        }
    })
</script>
@endsection