@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [REKAPITULASI]</h1>
                        </div>
                        <div class="box-body">
                            <h3 class="text-center">{{ $opd }}</h3>
                            <p>
                            <ul>
                                <li>Jumlah Paket : {{ $paket }}</li>
                                <li>Total Anggaran : {{ \FormatUang::format($anggaran) }}</li>
                                <li>Persentase Kegiatan:
                                    {{ number_format(((array_sum(array_column($data, 'rKegiatan')) / $paket) * 100) / 100, 2) }}%
                                </li>
                                <li>Persentase Keuangan:
                                    {{ number_format(\FormatUang::persen(array_sum(array_column($data, 'rKeuangan')), $anggaran), 2) . '%' }}
                                </li>
                            </ul>
                            </p>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">No</th>
                                            <th rowspan="3">BULAN</th>
                                            <th colspan="2" class="text-center">KEGIATAN</th>
                                            <th colspan="3" class="text-center">KEUANGAN</th>
                                            <th rowspan="3">STATUS</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">TARGET</th>
                                            <th rowspan="2">REALISASI</th>
                                        </tr>
                                        <tr>
                                            <th>TARGET</th>
                                            <th>REALISASI</th>
                                            <th>PERSENTASE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data != null)
                                            @foreach ($data as $key => $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item ? $bulan[$key] : '' }}</td>
                                                    <td>{{ $item ? $item['tKegiatan'] . '%' : '' . '%' }}</td>
                                                    <td>{{ $item ? $item['rKegiatan'] . '%' : '' }}
                                                    </td>
                                                    <td>{{ \FormatUang::format($item ? $item['tKeuangan'] : 0) }}</td>
                                                    <td>{{ \FormatUang::format($item ? $item['rKeuangan'] : 0) }}</td>
                                                    <td>
                                                        {{ number_format(\FormatUang::persen($item ? $item['rKeuangan'] : 0, $anggaran), 2) . '%' }}
                                                    </td>
                                                    <td>
                                                        {{-- @dd($item['cek']) --}}
                                                        @foreach ($item['cek'] as $status)
                                                        @endforeach
                                                        @if ($status->status == 1)
                                                        <button class="btn btn-fw btn-sm primary">MELAPOR</button>
                                                        @else
                                                        <button class="btn btn-fw btn-sm danger">TIDAK MELAPOR</button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="2"><strong>TOTAL</strong></td>
                                                <td>
                                                    <strong>100%</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ number_format(((array_sum(array_column($data, 'rKegiatan')) / $paket) * 100) / 100, 2) }}%</strong>
                                                </td>
                                                <td><strong>{{ \FormatUang::format(array_sum(array_column($data, 'tKeuangan'))) }}</strong>
                                                </td>
                                                <td><strong>{{ \FormatUang::format(array_sum(array_column($data, 'rKeuangan'))) }}</strong>
                                                </td>
                                                <td><strong>{{ number_format(\FormatUang::persen(array_sum(array_column($data, 'rKeuangan')), $anggaran), 2) . '%' }}</strong>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
        $(document).ready(function() {
            $("#table").DataTable();
        });
    </script>
@endpush
