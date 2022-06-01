<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link rel="stylesheet" href="{{ url('assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>JADWAL</title>

    <style>
        @page {
            size: A4;
            margin: 0;
        }

        .table-style {
            margin-left: 2%;
            margin-right: 2%;
        }

        .header {
            text-align: center;
        }

    </style>
</head>

<body>
    @if (Auth()->user()->isAdmin == 1)
        <div class="header mt-2">
            <img src="{{ asset('storage/uploads/lambang.jpg') }}" alt="logo" class="float-start"
                style="max-width: 120px; margin-left: 13%; margin-right: -50%">
            <div>
                <h5>JADWAL KEGIATAN BELANJA LANGSUNG</h5>
                <h5>SUMBER DANA {{ strtoupper($dana) }}</h5>
                <h5> TAHUN ANGGARAN {{ $pak }}</h5>
                <h5>BAGIAN {{ strtoupper($opd) }}</h5>
                <hr>
            </div>
        </div>
        <div class="table-style ">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th rowspan="2">NO</th>
                        <th rowspan="2">NAMA SUB KEGIATAN</th>
                        <th rowspan="2">ANGGARAN(RP.)</th>
                        <th rowspan="2">LOKASI</th>
                        <th rowspan="2">PPTK</th>
                        <th colspan="12">Target Kegiatan</th>
                        <th rowspan="2">PARAF PPTK</th>
                    </tr>
                    <tr>
                        @foreach ($bulan as $key => $value)
                            <th>{{ $value->id }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ \FormatUang::format(\FormatUang::getanggaran($item->anggaran)) }}</td>
                            <td>{{ \FormatUang::getlokasi($item->id) }}</td>
                            <td>{{ \FormatUang::getpptk($item->id) }}</td>
                            @foreach (\FormatUang::jdwlTarget($item->id) as $key => $item)
                                <td>{{ $item->persentase }}</td>
                            @endforeach
                            <td>{{ $loop->iteration }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="18">
                            <p><strong>Jumlah Kegiatan : {{ count($data) }}</strong></p>
                            <p><strong>Total Anggaran :
                                    {{ 'Rp.' . \FormatUang::format($anggaran) }}
                                </strong>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-md-8 col-lg-8 col-sm-8"></div>
            <div class="col-md-4 col-lg-4 col-sm-4 mt-5">
                <p class="text-center">Pamekasan,
                    {{ \FormatUang::tanggal(\Carbon\Carbon::now()->format('d-m-Y')) }}
                    <br>Mengetahui, <br> Pimpinan OPD
                </p>
                <p class="text-center mt-5"><strong><u>{{ strtoupper($skpd) }}</u></strong></p>
            </div>
        </div>
    @endif
    <div class="header mt-2">
        <img src="{{ asset('storage/uploads/lambang.jpg') }}" alt="logo" class="float-start"
            style="max-width: 120px; margin-left: 13%; margin-right: -50%">
        <div>
            <h5>JADWAL KEGIATAN BELANJA LANGSUNG</h5>
            <h5>SUMBER DANA {{ strtoupper($dana) }}</h5>
            <h5> TAHUN ANGGARAN {{ $pak }}</h5>
            <h5>BAGIAN {{ strtoupper($opd) }}</h5>
            <hr>
        </div>
    </div>
    <div class="table-style ">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">NO</th>
                    <th rowspan="2">NAMA SUB KEGIATAN</th>
                    <th rowspan="2">ANGGARAN(RP.)</th>
                    <th rowspan="2">LOKASI</th>
                    <th rowspan="2">PPTK</th>
                    <th colspan="12">Target Kegiatan</th>
                    <th rowspan="2">PARAF PPTK</th>
                </tr>
                <tr>
                    @foreach ($bulan as $key => $value)
                        <th>{{ $value->id }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ \FormatUang::format(\FormatUang::getanggaran($item->anggaran)) }}</td>
                        <td>{{ \FormatUang::getlokasi($item->id) }}</td>
                        <td>{{ \FormatUang::getpptk($item->id) }}</td>
                        @foreach (\FormatUang::jdwlTarget($item->id) as $key => $item)
                            <td>{{ $item->persentase }}</td>
                        @endforeach
                        <td>{{ $loop->iteration }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="18">
                        <p><strong>Jumlah Kegiatan : {{ count($data) }}</strong></p>
                        <p><strong>Total Anggaran :
                                {{ 'Rp.' . \FormatUang::format($anggaran) }}
                            </strong>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-8 col-sm-8"></div>
        <div class="col-md-4 col-lg-4 col-sm-4 mt-5">
            <p class="text-center">Pamekasan,
                {{ \FormatUang::tanggal(\Carbon\Carbon::now()->format('d-m-Y')) }}
                <br>Mengetahui, <br> Pimpinan OPD
            </p>
            <p class="text-center mt-5"><strong><u>{{ strtoupper($skpd) }}</u></strong></p>
        </div>
    </div>
</body>
<script>
    // window.print();
</script>

</html>
