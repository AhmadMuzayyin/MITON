<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="{{ url('assets/bootstrap/dist/css/bootstrap.min.css') }}" type="text/css" />

    {{-- DataTable --}}
    <link rel="stylesheet" href="{{ url('assets/DataTable/Table/css/dataTables.bootstrap4.min.css') }}">
    <title>Document</title>
</head>

<body>
    @if (Auth()->user()->isAdmin != 1)
        @if ($print == 'pengadaan')
            <h5 class="text-center">DAFTAR KEGIATAN {{ $dana ? strtoupper($dana) : '' }}<br> TAHUN
                ANGGARAN
                {{ $pak ? $pak : '' }}<br> {{ $skpd ? $skpd : '' }}
            </h5>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Sub Kegiatan</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Pelaksanaan</th>
                        <th scope="col">Program Prioritas Bupati</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th>{{ $item ? $loop->iteration : '' }}</th>
                            <td>{{ $item ? $item->nama : '' }}</td>
                            <td>
                                @foreach ($item->anggaran as $val)
                                    {{ $val ? 'Rp.' . \FormatUang::format($val->anggaran) : '' }}
                                @endforeach
                            </td>
                            <td>{{ $item ? $item->pelaksanaan->nama : '' }}</td>
                            <td>{{ $item ? $item->program : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($print == 'dau' || $print == 'dak' || $print == 'dbhc')
            <h5 class="text-center">DAFTAR KEGIATAN SUMBER DANA {{ $dana ? $dana : '' }}<br> TAHUN
                ANGGARAN
                {{ $pak ? $pak : '' }}<br> {{ $skpd ? $skpd : '' }}
            </h5>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Sub Kegiatan</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Pelaksanaan</th>
                        <th scope="col">Program Prioritas Bupati</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th>{{ $item ? $loop->iteration : '' }}</th>
                            <td>{{ $item ? $item->nama : '' }}</td>
                            <td>
                                @foreach ($item->anggaran as $val)
                                    {{ $val ? 'Rp.' . \FormatUang::format($val->anggaran) : '' }}
                                @endforeach
                            </td>
                            <td>{{ $item ? $item->pelaksanaan->nama : '' }}</td>
                            <td>{{ $item ? $item->program : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if ($print == 'kendala')
            <h5 class="text-center">DAFTAR KEGIATAN {{ $dana ? strtoupper($dana) : '' }}<br> TAHUN
                ANGGARAN
                {{ $pak ? $pak : '' }}<br> {{ $skpd ? $skpd : '' }}
            </h5>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Sub Kegiatan</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Pelaksanaan</th>
                        <th scope="col">Kendala</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th>{{ $item ? $loop->iteration : '' }}</th>
                            <td>{{ $item ? $item->activity->nama : '' }}</td>
                            <td>
                                {{ $anggaran ? 'Rp.' . \FormatUang::format($anggaran->anggaran) : '' }}
                            </td>
                            <td>{{ $item->activity->pelaksanaan->nama ?? '' }}</td>
                            <td>{{ $item ? $item->kendala : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        @if ($print == 'pengadaan')
            <h5 class="text-center">DAFTAR KEGIATAN {{ $dana ? strtoupper($dana) : '' }}<br> TAHUN
                ANGGARAN
                {{ $pak ? $pak : '' }}<br> {{ $skpd ? $skpd : '' }}
            </h5>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">SKPD</th>
                        <th scope="col">Nomor Rekening</th>
                        <th scope="col">Nama Sub Kegiatan</th>
                        <th scope="col">Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th>{{ $item ? $loop->iteration : '' }}</th>
                            <td>{{ $item ? $item->user->nama_SKPD : '' }}</td>
                            <td>{{ $item ? $item->rek : '' }}</td>
                            <td>{{ $item ? $item->kegiatan : '' }}</td>
                            <td>
                                @foreach ($item->anggaran as $val)
                                    {{ $val ? 'Rp.' . \FormatUang::format($val->anggaran) : '' }}
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @elseif ($print == 'dau' || $print == 'dak' || $print == 'dbhc')
            <h5 class="text-center">DAFTAR KEGIATAN SUMBER DANA {{ $dana ? $dana : '' }}<br> TAHUN
                ANGGARAN
                {{ $pak ? $pak : '' }}<br> {{ $skpd ? $skpd : '' }}
            </h5>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">SKPD</th>
                        <th scope="col">Nomor Rekening</th>
                        <th scope="col">Nama Sub Kegiatan</th>
                        <th scope="col">Anggaran</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th>{{ $item ? $loop->iteration : '' }}</th>
                            <td>{{ $item ? $item->user->nama_SKPD : '' }}</td>
                            <td>{{ $item ? $item->rek : '' }}</td>
                            <td>{{ $item ? $item->kegiatan : '' }}</td>
                            <td>
                                @foreach ($item->anggaran as $val)
                                    {{ $val ? 'Rp.' . \FormatUang::format($val->anggaran) : '' }}
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        @if ($print == 'kendala')
            <h5 class="text-center">DAFTAR KEGIATAN {{ $dana ? strtoupper($dana) : '' }}<br> TAHUN
                ANGGARAN
                {{ $pak ? $pak : '' }}<br> {{ $skpd ? $skpd : '' }}
            </h5>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Sub Kegiatan</th>
                        <th scope="col">Anggaran</th>
                        <th scope="col">Pelaksanaan</th>
                        <th scope="col">Kendala</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <th>{{ $item ? $loop->iteration : '' }}</th>
                            <td>{{ $item ? $item->nama : '' }}</td>
                            <td>
                                @foreach ($item->anggaran as $val)
                                    {{ $val ? 'Rp.' . \FormatUang::format($val->anggaran) : '' }}
                                @endforeach
                            </td>
                            <td>{{ $item ? $item->pelaksanaan->nama : '' }}</td>
                            <td>{{ $item ? $item->program : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif
</body>
<!-- jQuery -->
<script src="{{ url('assets/libs/jquery/jquery/dist/jquery-3.1.1.js') }}"></script>
<script src="{{ url('assets/libs/jquery/bootstrap/dist/js/bootstrap.js') }}"></script>
<script src="{{ url('assets/DataTable/Table/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/DataTable/Table/js/dataTables.bootstrap4.min.js') }}"></script>

</html>
