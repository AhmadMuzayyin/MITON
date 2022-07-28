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
    <div class="table-style">
        <table class="table table-bordered mt-2" id="nilai">
            <thead>
                <tr>
                    <th class="text-center" rowspan="2">NO</th>
                    <th class="text-center" rowspan="2">NAMA SUB KEGIATAN</th>
                    <th class="text-center" rowspan="2">ANGGARAN (Rp.)</th>
                    <th class="text-center" rowspan="2">BOBOT</th>
                    <th class="text-center" rowspan="2">VOLUME</th>
                    <th class="text-center" rowspan="2">LOKASI</th>
                    <th class="text-center" rowspan="2">PPTK</th>
                    <th class="text-center" rowspan="2">JENIS PENGADAAN</th>
                    <th class="text-center" colspan="2">REALISASI KEGIATAN</th>
                    <th class="text-center" colspan="4">REALISASI KEUANGAN</th>
                </tr>
                <tr>
                    <th class="text-center">TARGET</th>
                    <th class="text-center">LAPORAN</th>
                    <th class="text-center">TARGET</th>
                    <th class="text-center">LAPORAN(%)</th>
                    <th class="text-center">LAPORAN(Rp.)</th>
                    <th class="text-center">SISA</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center" style="font-size: 90%">{{ $loop->iteration }}</td>
                        <td class="text-center" style="font-size: 90%" style="font-size: 80%">
                            {{ $item['sub']['nama'] }}</td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::format(\FormatUang::getanggaran($item['sub']->anggaran)) }}</td>
                        <td class="text-center" style="font-size: 90%">
                            {{ number_format(\FormatUang::getbobot(\FormatUang::getanggaran($item['sub']->anggaran), $data), 2) }}
                        </td>
                        <td class="text-center" style="font-size: 90%">{{ strtoupper(1 . ' PAKET') }}</td>
                        <td class="text-center" style="font-size: 90%" style="font-size: 80%">
                            <?php $lokasi = \FormatUang::getlokasi($item['lokasi']); $numb = 1;?>
                            @foreach ($lokasi as $lok)
                                {{ $numb++ }}. {{ $lok->lokasi }} <br>
                            @endforeach
                        </td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::getpptk($item['sub']->id) }}</td>
                        <td class="text-center" style="font-size: 90%">{{ $item['sub']->pengadaan->nama }}</td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::gettarget($item['sub']->id, $bulan->id) }}
                        </td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::getLkg($item['sub']->id, $item['sub']->sumber_dana_id, $bulan->id) }}
                        </td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::format(\FormatUang::gettku($item['sub']->id, \FormatUang::getanggaran($item['sub']->anggaran), $bulan->id)) }}
                        </td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::getLP($item['sub']->id,\FormatUang::getanggaran($item['sub']->anggaran),$item['sub']->sumber_dana_id,$bulan->id) }}
                        </td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::format(\FormatUang::getLPR($item['sub']->id, $item['sub']->sumber_dana_id, $bulan->id)) }}
                        </td>
                        <td class="text-center" style="font-size: 90%">
                            {{ \FormatUang::format(\FormatUang::getsisa($item['sub']->id,\FormatUang::getanggaran($item['sub']->anggaran),$item['sub']->sumber_dana_id,$bulan->id)) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-center" colspan="2"><strong>JUMLAH</strong></td>
                    <td class="text-center">
                        <strong>{{ \FormatUang::format(array_sum(array_column($data, 'total'))) }}</strong>
                    </td>
                    <td class="text-center"><strong>100</strong></td>
                    <td class="text-center"> </td>
                    <td class="text-center"> </td>
                    <td class="text-center"> </td>
                    <td class="text-center"> </td>
                    <td class="text-center">
                        <strong>{{ number_format(array_sum(array_column($data, 'target')), 2) }}</strong>
                    </td>
                    <td class="text-center">
                        <strong>{{ number_format(array_sum(array_column($data, 'kglapor')), 2) }}</strong>
                    </td>
                    <td class="text-center">
                        <strong>{{ number_format(array_sum(array_column($data, 'tku')), 2) }}</strong>
                    </td>
                    <td class="text-center">
                        <strong>{{ number_format(array_sum(array_column($data, 'kulapor')), 2) }}</strong>
                    </td>
                    <td class="text-center">
                        <strong>{{ \Formatuang::format(array_sum(array_column($data, 'kulapor2'))) }}</strong>
                    </td>
                    <td class="text-center">
                        <strong>{{ \Formatuang::format($sisa) }}</strong>
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
            <p class="text-center mt-5"><strong><u>{{ strtoupper($opd->nama_KPA) }}</u></strong></p>
        </div>
    </div>
</body>
<script>
    // window.print();
</script>

</html>
