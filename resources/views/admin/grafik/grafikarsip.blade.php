<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ url('assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>RFK</title>

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        .header {
            text-align: center;
        }

    </style>
</head>

<body>
    <div class="header mt-2">
        <img src="{{ asset('storage/uploads/lambang.jpg') }}" alt="logo" class="float-start"
            style="max-width: 120px; margin-left: 13%; margin-right: -50%">
        <div>
            <h5>PEMERINTAH KABUPATEN PAMEKASAN {{ strtoupper($dana->nama) }}</h5>
            <h5>REALISASI KEGIATAN DAN KEUANGAN</h5>
            <h5>BULAN {{ strtoupper($bulan->nama) }} ANGGARAN {{ strtoupper($pak->nama) }}</h5>
            <h5>BAGIAN {{ strtoupper($opd->nama_SKPD) }}</h5>
            <hr>
        </div>
    </div>
    <input type="hidden" name="dana" value="{{ $dana->id }}">
    <input type="hidden" name="bulan" value="{{ $bulan->id }}">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <canvas id="myChart" style='width:300px !important;height:300px !important'></canvas>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-8"></div>
        <div class="col-md-4 col-lg-4 col-sm-4 mt-5">
            <p class="text-center">Pamekasan,
                {{ \FormatUang::tanggal(\Carbon\Carbon::now()->format('d-m-Y')) }}
                <br>Mengetahui, <br> Pimpinan OPD
            </p>
            <p class="text-center mt-5"><strong><u>{{ strtoupper($opd->nama_KPA) }}</u></strong></p>
        </div>
    </div>
</body>
<script src="{{ url('assets/libs/jquery/jquery/dist/jquery-3.1.1.js') }}"></script>
{{-- ChartsJS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"
integrity="sha256-Y26AMvaIfrZ1EQU49pf6H4QzVTrOI8m9wQYKkftBt4s=" crossorigin="anonymous"></script>
<script>
    const data = {
        labels: ['Kegiatan', 'Keuangan'],
        datasets: [{
                label: 'Target (%)',
                data: [{{ $kegiatan[0] }}, {{ $keuangan[0] }}],
                borderColor: 'rgb(255, 0, 0)',
                backgroundColor: 'rgb(255, 0, 0)',
            },
            {
                label: 'Realisasi (%)',
                data: [{{ $kegiatan[1] }}, {{ $keuangan[1] }}],
                borderColor: 'rgb(0, 255, 0)',
                backgroundColor: 'rgb(0, 255, 0)',
            }
        ]
    }
    const config = {
        type: 'bar',
        data: data,
        options: {
            maintainAspectRatio: false
        },
    };
    const myChart = new Chart(document.getElementById('myChart').getContext('2d'), config);
</script>

</html>
