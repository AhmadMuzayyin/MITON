@extends('template.main')

@section('content')
<div ui-view class="app-body" id="view">
    <!-- ############ PAGE START-->
    {{-- @dd($pak_id != null ? $pak_id : '') --}}
    <div class="p-a white lt box-shadow">
        <div class="row">
            <div class="col-sm-6">
                <h4 class="mb-0 _300">WELCOME TO RAFIKA</h4>
                <small class="text-muted">APLIKASI REALISASI FISIK DAN KEUANGAN</small>
            </div>
        </div>
    </div>
    <div class="padding">
        <div class="row">
            <div class="col-xs-12 col-sm-4">
                <div class="box p-a">
                    <div class="pull-left m-r">
                        <span class="w-48 rounded  accent">
                            <i class="material-icons">&#xe151;</i>
                        </span>
                    </div>
                    <div class="clear">
                        <h4 class="m-0 text-lg _300">
                            <a href="{{ url('activity') }}">{{ $jml_sub }}
                                <span class="text-sm">SUB KEGIATAN</span>
                            </a>
                        </h4>
                        <small class="text-muted">{{ $jml_sub_lapor }} Sudah melapor bulan ini.</small>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4">
                <div class="box p-a">
                    <div class="pull-left m-r">
                        <span class="w-48 rounded primary">
                            <i class="material-icons">&#xe54f;</i>
                        </span>
                    </div>
                    <div class="clear">
                        <h4 class="m-0 text-lg _300"><a href>{{ $jml_dana }} <span class="text-sm">SUMBER
                                    DANA</span></a>
                        </h4>
                        <small class="text-muted">{{ $jml_dana_pake }} Sudah Terpakai.</small>
                    </div>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4">
                <div class="box p-a">
                    <div class="pull-left m-r">
                        <span class="w-48 rounded warn">
                            <i class="material-icons">&#xe8d3;</i>
                        </span>
                    </div>
                    <div class="clear">
                        <h4 class="m-0 text-lg _300"><a href>{{ $jml_pengadaan }} <span class="text-sm">JENIS
                                    PENGADAAN</span></a>
                        </h4>
                        <small class="text-muted">{{ $jml_png_pake }} Sudah Terpakai.</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-body">
                        <canvas id="myChart" style='width:300px !important;height:300px !important'></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-body">
                        <canvas id="chart2" style='width:300px !important;height:300px !important'></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ############ PAGE END-->

</div>
@endsection

@push('script')
<script>
    function titleCase(str) {
        var splitStr = str.toLowerCase().split(' ');
        for (var i = 0; i < splitStr.length; i++) {
            splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
        }
        return splitStr.join(' ');
    }

    const bulan = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    ];

    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "{{ route('dashboard-data') }}",
            success: function(res) {
                const datasets = [{
                        label: 'Realisasi Keuangan',
                        backgroundColor: 'rgb(101, 222, 20)',
                        borderColor: 'rgb(101, 222, 20)',
                        data: res.realisasi.map((v, i) => {
                            return res.realisasi.slice(0, i).reduce((prev, cur) =>
                                prev += cur, res.realisasi[0]);
                        })
                    },
                    {
                        label: 'Target Keuangan',
                        backgroundColor: 'rgb(110, 22, 12)',
                        borderColor: 'rgb(110, 22, 12)',
                        data: res.target.map((v, i) => {
                            return res.target.slice(0, i).reduce((prev, cur) => prev +=
                                cur, res.target[0]);
                        })
                    }
                ];
                const ctx = document.getElementById('myChart').getContext('2d');
                const data = {
                    labels: bulan,
                    datasets: datasets
                };
                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        maintainAspectRatio: false,
                    }
                };
                const myChart = new Chart(ctx, config);
            }
        });
    });
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "{{ route('dashboard-data-kg') }}",
            success: function(res) {
                const datasets = [{
                        label: 'Realisasi Kegiatan',
                        backgroundColor: 'rgb(101, 222, 20)',
                        borderColor: 'rgb(101, 222, 20)',
                        data: res.realisasi.map((v, i) => {
                            return res.realisasi.slice(0, i).reduce((prev, cur) =>
                                prev += cur, res.realisasi[0]);
                        })
                    },
                    {
                        label: 'Target Kegiatan',
                        backgroundColor: 'rgb(110, 22, 12)',
                        borderColor: 'rgb(110, 22, 12)',
                        data: res.target.map((v, i) => {
                            return res.target.slice(0, i).reduce((prev, cur) => prev +=
                                cur, res.target[0]);
                        })
                    }
                ];
                const ctx = document.getElementById('chart2').getContext('2d');
                const data = {
                    labels: bulan,
                    datasets: datasets
                };
                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        maintainAspectRatio: false,
                    }
                };
                const myChart = new Chart(ctx, config);
            }
        });
    });
</script>
@endpush