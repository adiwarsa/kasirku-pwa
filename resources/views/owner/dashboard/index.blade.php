@extends('layouts.app')
@section('container.isi')
@section('active_dash', 'active')

@section('container.css')
    <style>
        .supplier {
            /* background-image: radial-gradient(circle at 47.78% 51.28%, #ebcb5a 0, #f0c050 12.5%, #f4b547 25%, #f7a83f 37.5%, #fa9a38 50%, #fc8b34 62.5%, #fe7c34 75%, #ff6d37 87.5%, #ff5d3d 100%); */
            background-image: linear-gradient(to left bottom, #ddc4dd, #ddc6e0, #ddc8e3, #dccae5, #dccce8, #d9c8e8, #d5c4e8, #d1c0e8, #c8b5e6, #beabe3, #b4a1e1, #a997df);
        }

        .produk {
            /* background-image: radial-gradient(circle at 49.99% 50.05%, #829fff 0, #4973e4 50%, #07499d 100%); */
            background-image: linear-gradient(to right top, #256d85, #247b9a, #2488b1, #2996c8, #33a3df, #4aafe9, #5ebbf4, #70c7fe, #8cd4fd, #a8e0fd, #c3ebfd, #dff6ff);
        }

        .penghasilan {
            /* background-image: radial-gradient(circle at 47.69% 54.01%, #9ddd89 0, #8cd989 12.5%, #76d388 25%, #59ca84 37.5%, #2cbe7e 50%, #00b279 62.5%, #00a979 75%, #00a17b 87.5%, #009d81 100%); */
            background-image: linear-gradient(to right top, #9effe1, #89f7ee, #7eeef9, #80e3fe, #8bd7ff, #96d5ff, #a1d2ff, #abd0ff, #b0d8ff, #b8dfff, #c1e6ff, #ccedff);
        }
    </style>
@endsection

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon supplier">
                <i class="fas fa-archive"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Supplier</h4>
                </div>
                <div class="card-body">
                    {{ $data['total_supplier'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon produk">
                <i class="fas fa-dice-d6"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Produk</h4>
                </div>
                <div class="card-body">
                    {{ $data['total_produk'] }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row d-flex justify-content-around">
    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon penghasilan">
                <i class="fas fa-money-check"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Penjualan Hari Ini</h4>
                </div>
                <div class="card-body">
                    @currency($totalPendapatan)
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon penghasilan">
                <i class="fas fa-money-check"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Keuntungan Hari Ini</h4>
                </div>
                <div class="card-body">
                    @currency($totalKeuntungan)
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section-body">
    <div class="row">
        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center">
                        <div class="form-group col-md-4">
                            <select id="tanggal_chart" class="form-control" onchange="filterChart()">
                                @foreach ($tanggal as $key => $value)
                                    <option
                                        value="{{ $value['minggu_awal'] . '&' . $value['minggu_akhir'] . '&' . $value['minggu_berapa'] }}"
                                        @if ($value['minggu_awal'] . '&' . $value['minggu_akhir'] == $data['minggu_sekarang']) selected @endif>
                                        {{ $value['minggu_berapa'] }}
                                    </option>
                                @endforeach
                                @if ($value['minggu_awal'] . '&' . $value['minggu_akhir'] != $data['minggu_sekarang'])
                                    <option value="{{ $data['minggu_sekarang'] . '&' . $data['minggu_sekarang_ke'] }}"
                                        selected>
                                        {{ $data['minggu_sekarang_ke'] }}
                                    </option>
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">

                        <div class="row">
                            <div class="mb-3 col-md-5">
                                <label for="tanggal_pertama" class="form-label">Tanggal Pertama</label>
                                <input type="date" class="form-control date" id="tanggal_pertama"
                                    name="tanggal_pertama" onchange="chartTanggal('tanggal_pertama')"
                                    data-date-format="DD/MM/YYYY"
                                    style="height: 2.2rem !important; width: 130% !important; margin: 1 !important;"
                                    required>
                            </div>
                            <div class="mb-3 ml-2 col-md-5">
                                <label for="tanggal_kedua" class="form-label">Tanggal Kedua</label>
                                <input type="date" class="form-control date" id="tanggal_kedua" name="tanggal_kedua"
                                    onchange="chartTanggal('tanggal_kedua')" data-date-format="DD/MM/YYYY"
                                    style="height: 2.2rem !important;  width: 130% !important;">
                            </div>
                            <div class="col-md-1 ml-2" style="margin-top: 9.5%;">
                                <button type="button" class="btn btn-danger" id="btn_x" onclick="reset()"
                                    disabled>X</button>
                            </div>
                        </div>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('container.js')
    <script>
        $(document).ready(function() {
            filterChart();
        });

        $(".date").on("change", function() {
            if (this.value) {
                this.setAttribute(
                    "data-date",
                    moment(this.value, "YYYY-MM-DD")
                    .format(this.getAttribute("data-date-format"))
                )
            } else {
                $(this).attr('data-date', 'dd/mm/yyyy');

            }
        }).trigger("change")

        function filterChart() {
            $('#chart').fadeIn("slow");
            $('#chart').html('');
            let tanggal_pertama = $('#tanggal_pertama').val();
            let tanggal_kedua = $('#tanggal_kedua').val();

            var data_dibawa = "";

            if (tanggal_pertama != "" && tanggal_kedua != "") {
                data_dibawa = "perbulan&" + tanggal_pertama + "&" + tanggal_kedua;
            } else {
                data_dibawa = "perminggu&" + $('#tanggal_chart').val();
            }

            $.get("{{ url('dashboard/chart') }}/" + data_dibawa, {}, function(data, status) {
                console.log(data);
                var options = {
                    series: [{
                        name: 'Data Penjualan',
                        data: data['penjualan']
                    }],
                    chart: {
                        type: 'area',
                        stacked: false,
                        height: 350,
                        zoom: {
                            enabled: false
                        },
                    },

                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        size: 0,
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            inverseColors: false,
                            opacityFrom: 0.45,
                            opacityTo: 0.05,
                            stops: [20, 100, 100, 100]
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#8e8da4',
                            },
                            offsetX: 0,
                            formatter: function(val) {
                                return (FormatRupiah(val));
                            },
                        },
                        axisBorder: {
                            show: false,
                        },
                        axisTicks: {
                            show: false
                        }
                    },
                    xaxis: {
                        categories: data['hari'],
                        labels: {
                            formatter: function(val) {
                                return val
                            }
                        }
                    },
                    title: {
                        text: "Data Penjualan " + data['title'],
                        align: 'left',
                        offsetX: 14
                    },
                    tooltip: {
                        shared: true
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetX: -10
                    }
                };

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            });

        }

        function chartTanggal(status) {
            let tanggal_pertama = $('#tanggal_pertama');
            let tanggal_kedua = $('#tanggal_kedua');

            if (tanggal_pertama.val() != "" || tanggal_kedua.val() != "") {
                $("#tanggal_chart").prop('disabled', true);
                $("#btn_x").prop('disabled', false);

                if (tanggal_pertama.val() != "" && tanggal_kedua.val() != "") {
                    filterChart();
                }
            }
            FilterTanggal(status);
        }

        function reset() {
            $("#tanggal_chart").prop('disabled', false);
            $("#btn_x").prop('disabled', true);
            $('#tanggal_pertama').val('');
            $('#tanggal_kedua').val('');
            $('#tanggal_pertama').attr('data-date', 'dd/mm/yyyy');
            $('#tanggal_kedua').attr('data-date', 'dd/mm/yyyy');
            $('#tanggal_kedua').attr('min', '');
            $('#tanggal_pertama').attr('max', '');
            filterChart();
        }
    </script>
@endsection
@endsection
