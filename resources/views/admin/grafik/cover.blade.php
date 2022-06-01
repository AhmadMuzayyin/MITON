<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ url('assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" />
    <title>COVER</title>

    <style>
        .text-center,
        h3 {
            text-align: center
        }

    </style>
</head>

<body>
    <div class="text-center">
        <h5>HASIL EVALUASI {{ strtoupper($dana) }}</h5>
        <h5>{{ strtoupper($bulan) }} TAHUN ANGGARA {{ $pak }}</h5>
        <h5>BAGIAN {{ strtoupper($opd) }}</h5>
        <hr>
    </div>
    <div class="container-sm">
        <ol>
            <li>
                <div class="row">
                    <div class="col"><strong>Jumlah Paket Sub Kegiatan </strong></div>
                    <div class="col-md-2 col-sm-2"><span>: {{ count($data) }}</span></div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col"><strong>Jumlah Anggaran </strong></div>
                    <div class="col-md-2 col-sm-2">
                        <span>: {{ \FormatUang::format($anggaran) }}</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col"><strong>Realisasi Keuangan s/d Bulan ini </strong></div>
                    <div class="col-md-2 col-sm-2">
                        <span>:
                            {{ \FormatUang::format($realkeuangan) }}</span>
                    </div>
                </div>
            </li>
            <li>
                <div class="row">
                    <div class="col">
                        <strong>Rata-rata Realisasi Fisik Sub Kegiatan </strong>
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <span>: {{ $rata . '%' }}</span>
                    </div>
                </div>
            </li>
            <li><strong>Klasifikasi Realisasi Paket Sub Kegiatan</strong></li>
            <ul>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>a. Paket Sub Kegiatan 0%</strong>
                            <ul>
                                @foreach ($ag as $item)
                                    @if ($item->month_id == 1)
                                        @if (\FormatUang::persen($item->keuangan_sekarang, $anggaran) * 100 == 0)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @else
                                        @if (\FormatUang::persen($item->keuangan_lalu, $anggaran) * 100 == 0)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ $klasifikasi['paketsatu'] }}
                            </span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>b. Paket Sub Kegiatan 0% < x < 25%</strong>
                                    <ul>
                                        @foreach ($ag as $item)
                                            @if ($item->month_id == 1)
                                                @if (\FormatUang::persen($item->keuangan_sekarang, $anggaran) <= 25)
                                                    <li>{{ $item->activity->nama }}</li>
                                                @endif
                                            @else
                                                @if (\FormatUang::persen($item->keuangan_lalu, $anggaran) <= 25)
                                                    <li>{{ $item->activity->nama }}</li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ $klasifikasi['paketdua'] }}
                            </span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>c. Paket Sub Kegiatan 25% s/d 50%</strong>
                            <ul>
                                @foreach ($ag as $item)
                                    @if ($item->month_id)
                                        @if (\FormatUang::persen($item->keuangan_sekarang, $anggaran) >= 25 && \FormatUang::persen($item->keuangan_sekarang, $anggaran) <= 50)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @else
                                        @if (\FormatUang::persen($item->keuangan_lalu, $anggaran) >= 25 && \FormatUang::persen($item->keuangan_lalu, $anggaran) <= 50)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ $klasifikasi['pakettiga'] }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>d. Paket Sub Kegiatan 50% s/d 75%</strong>
                            <ul>
                                @foreach ($ag as $item)
                                    @if ($item->month_id)
                                        @if (\FormatUang::persen($item->keuangan_sekarang, $anggaran) >= 50 && \FormatUang::persen($item->keuangan_sekarang, $anggaran) <= 75)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @else
                                        @if (\FormatUang::persen($item->keuangan_lalu, $anggaran) >= 70 && \FormatUang::persen($item->keuangan_lalu, $anggaran) <= 50)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ $klasifikasi['paketempat'] }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>e. Paket Sub Kegiatan 75% < 100% </strong>
                                    <ul>
                                        @foreach ($ag as $item)
                                            @if ($item->month_id)
                                                @if (\FormatUang::persen($item->keuangan_sekarang, $anggaran) >= 75 && \FormatUang::persen($item->keuangan_sekarang, $anggaran) < 100)
                                                    <li>{{ $item->activity->nama }}</li>
                                                @endif
                                            @else
                                                @if (\FormatUang::persen($item->keuangan_lalu, $anggaran) >= 75 && \FormatUang::persen($item->keuangan_lalu, $anggaran) < 100)
                                                    <li>{{ $item->activity->nama }}</li>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ $klasifikasi['paketlima'] }}</span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col">
                            <strong>f. Paket Sub Kegiatan 100%</strong>
                            <ul>
                                @foreach ($ag as $item)
                                    @if ($item->month_id)
                                        @if (\FormatUang::persen($item->keuangan_sekarang, $anggaran) == 100)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @else
                                        @if (\FormatUang::persen($item->keuangan_lalu, $anggaran) == 100)
                                            <li>{{ $item->activity->nama }}</li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-2 col-sm-2">
                            <span>: {{ $klasifikasi['paketenam'] }}</span>
                        </div>
                    </div>
                </li>
            </ul>
        </ol>
    </div>
</body>
<script>
    // window.print();
</script>

</html>
