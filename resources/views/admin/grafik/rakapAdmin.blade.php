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
                            <form>
                                @csrf
                                {{-- @dd($bulan) --}}
                                <div class="row">
                                    <div class="col-md col-sm col-lg">
                                        <label for="bulan">BULAN:</label>
                                        <select class="form-control" id="bulanSelect" name="bulanSelect">
                                            @foreach ($bulan as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $selected ? 'selected' : '' }}>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="skpd">SKPD:</label>
                                        {{-- <select class="form-control" id="skpdSelect" name="skpdSelect">
                                            @foreach ($skpd as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $selected ? 'selected' : '' }}>
                                                    {{ $item->kode_SKPD }}
                                                </option>
                                            @endforeach
                                        </select> --}}
                                        <select class="form-control @error('skpdSelect') parsley-error @enderror" id="skpdSelect" name="skpdSelect">
                                            <option value="all" {{ request()->get('user') == 'all' ? 'selected' : '' }}>SELURUH SKPD</option>
                                            <option value="1.1.1" {{ request()->get('user') == '1.1.1' ? 'selected' : '' }}>Sekretariat Daerah</option>
                                            <option value="2.1.1" {{ request()->get('user') == '2.1.1' ? 'selected' : '' }}>Dinas</option>
                                            <option value="3.1.1" {{ request()->get('user') == '3.1.1' ? 'selected' : '' }}>Badan</option>
                                            <option value="4.1.1" {{ request()->get('user') == '4.1.1' ? 'selected' : '' }}>Kantor</option>
                                            <option value="5.1.1" {{ request()->get('user') == '5.1.1' ? 'selected' : '' }}>Kecamatan</option>
                                        </select>
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="dana">SUMBER DANA:</label>
                                        <select class="form-control" id="danaSelect" name="danaSelect">
                                            @foreach ($dana as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $selectedDana ? 'selected' : '' }}>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="table">
                                    <thead>
                                        <tr>
                                            <th rowspan="3">No</th>
                                            <th rowspan="3">OPD</th>
                                            <th rowspan="3">Anggaran</th>
                                            <th rowspan="3">Paket</th>
                                            <th colspan="2" class="text-center">KEGIATAN</th>
                                            <th colspan="2" class="text-center">KEUANGAN</th>
                                            <th rowspan="3">STATUS</th>
                                        </tr>
                                        <tr>
                                            <th rowspan="2">TARGET</th>
                                            <th rowspan="2">REALISASI</th>
                                        </tr>
                                        <tr>
                                            <th>TARGET</th>
                                            <th>REALISASI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_SKPD }}</td>
                                                <td>{{ \FormatUang::format($item->anggaran) }}</td>
                                                <td>{{ $item->user->activity->count() }}</td>
                                                <td>{{ $item->target->persentase }} %</td>
                                                <td>{{ $item->kegiatan_sekarang }} %</td>
                                                <td>{{ \FormatUang::format($item->t_keuangan->anggaran) }}</td>
                                                <td>{{ \FormatUang::format($item->keuangan_sekarang) }}</td>
                                                <td>
                                                    @if ($item->status == 1)
                                                        <button class="btn btn-fw btn-sm primary">MELAPOR</button>
                                                    @else
                                                        <button class="btn btn-fw btn-sm danger">TIDAK MELAPOR</button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Total</td>
                                            <td>{{ \FormatUang::format($rekap['anggaran']) }}</td>
                                            <td>{{ $rekap['paket'] }}</td>
                                            <td>{{ $rekap['tgf'] }}%</td>
                                            <td>{{ $rekap['rgf'] }}%</td>
                                            <td>{{ \FormatUang::format($rekap['tgu']) }}</td>
                                            <td>{{ \FormatUang::format($rekap['rgu']) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                                <a href="{{ url('/cetakRekap') }}" class="btn btn-primary" role="button">CETAK</a>
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
        $(document).ready(function() {
            $("#bulanSelect").change(function() {
                var _token = $("input[name='_token']").val();
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('rekapAdmin') }}',
                    data: {
                        _token: _token,
                        dana: dana,
                        bulan: bulan
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            window.location.href = '{{ route('rekap') }}?dana=' +
                                data.dana + '&bulan=' + data.bulan + '&user=' + skpd;
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });

            });
        });
        $(document).ready(function() {
            $("#danaSelect").change(function() {
                var _token = $("input[name='_token']").val();
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('rekapAdmin') }}',
                    data: {
                        _token: _token,
                        dana: dana,
                        bulan: bulan
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            window.location.href = '{{ route('rekap') }}?dana=' +
                                data.dana + '&bulan=' + data.bulan + '&user=' + skpd;
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });

            });
        });
        $(document).ready(function() {
            $("#skpdSelect").change(function() {
                var _token = $("input[name='_token']").val();
                var bulan = $("#bulanSelect option:selected").val();
                var dana = $("#danaSelect option:selected").val();
                var skpd = $("#skpdSelect option:selected").val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('rekapAdmin') }}',
                    data: {
                        _token: _token,
                        dana: dana,
                        bulan: bulan
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            window.location.href = '{{ route('rekap') }}?dana=' +
                                data.dana + '&bulan=' + data.bulan + '&user=' + skpd;
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });

            });
        });
    </script>
@endpush
