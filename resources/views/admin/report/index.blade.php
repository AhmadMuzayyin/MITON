@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">

                        <div class="box-header">
                            <h1>DATA [LAPORAN REALISASI KEGIATAN]</h1>
                            <form>
                                <div class="row mt-5">
                                    @csrf
                                    {{-- @dd($bulan) --}}
                                    <div class="col-md col-sm col-lg">
                                        <label for="bulan">BULAN:</label>
                                        <select class="custom-select form-control" id="bulanSelect" name="bulanSelect">
                                            @for ($i = 0; $i < $batas; $i++)
                                                <option value="{{ $bulan[$i]->id }}"
                                                    {{ $bulan[$i]->id == $selected->id ? 'selected' : '' }}>
                                                    {{ $bulan[$i]->nama }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md col-sm col-lg">
                                        <label for="dana">SUMBER DANA:</label>
                                        <select class="custom-select form-control" id="danaSelect" name="danaSelect">
                                            <option value="1" {{ $dana == 1 ? 'selected' : '' }}>
                                                APBD
                                                Kabupaten Pamekasan</option>
                                            <option value="2" {{ $dana == 2 ? 'selected' : '' }}>APBD
                                                Provinsi
                                            </option>
                                            <option value="3" {{ $dana == 3 ? 'selected' : '' }}>APBN
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="box-body">
                            @if (session('report'))
                                <div class="alert alert-warning" role="alert">
                                    {{ session('report') }}
                                </div>
                            @endif
                            <form action="{{ route('report.store') }}" method="POST">
                                @csrf
                                <div class="table-responsive">
                                    <table class="table table-bordered justify-content-centery align-items-center"
                                        id="table">
                                        <thead>
                                            <tr>
                                                <th class="tg-0pky" rowspan="2">No</th>
                                                <th class="tg-0pky" rowspan="2">SUB KEGIATAN</th>
                                                <th class="tg-0pky" colspan="2">KEGIATAN(%)</th>
                                                <th class="tg-0pky" colspan="2">KEUANGAN(Rp.)</th>
                                                <th class="tg-0pky" rowspan="2">KENDALA</th>
                                            </tr>
                                            <tr>
                                                <th class="tg-0pky">TARGET</th>
                                                <th class="tg-0pky">REALISASI</th>
                                                <th class="tg-0pky">SISA</th>
                                                <th class="tg-0pky">REALISASI</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_report">
                                            @foreach ($data as $item)
                                                <tr class="data-r">
                                                    <input type="hidden" class="form-control" name="id[]"
                                                        value="{{ $item->id }}">
                                                    <td id="no">{{ $loop->iteration }}</td>
                                                    <td id="kegiatan" style="font-size: 80%">
                                                        {{ $item->activity->kegiatan }}</td>

                                                    <td id="klalu">
                                                        {{ $item->target->persentase != null ? $item->target->persentase . '%' : '' }}
                                                    </td>
                                                    <td id="inkegiatan" class="text-center">
                                                        <input type="number" name="kegiatan[]" id="inputkegiatan"
                                                            style="max-width: 25px;"
                                                            value="{{ $item->kegiatan_sekarang ? $item->kegiatan_sekarang : '' }}">
                                                    </td>
                                                    <td id="anggaran">
                                                        {{ \FormatUang::format($item->t_keuangan->anggaran) }}
                                                    </td>
                                                    <td id="keuangan" class="text-center">
                                                        <input type="number" name="keuangan[]" id="keuangan"
                                                            style="max-width: 80px;"
                                                            value="{{ $item->keuangan_sekarang ? $item->keuangan_sekarang : '' }}">
                                                    </td>
                                                    <td id="kendala">
                                                        <input type="text" name="kendala[]" id="kendala"
                                                            value="{{ $item->kendala ? $item->kendala : '' }}"
                                                            style="max-width: 80px">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="col">
                                        @foreach ($aktif as $item)
                                            @if (Auth()->user()->isAdmin != 1)
                                                @if ($item->status == '1')
                                                    <button type="submit"
                                                        class="md-btn md-raised m-b-sm w-xs blue StoreReport"
                                                        role="button">SIMPAN
                                                    </button>
                                                @else
                                                    <div class=" alert alert-danger" role="alert">
                                                        Inputan dinonaktifkan, silahkan hubungi admin!
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </form>
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

                $.ajax({
                    type: 'POST',
                    url: '{{ route('getReport') }}',
                    data: {
                        _token: _token,
                        dana: dana,
                        bulan: bulan
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            window.location.href = '{{ route('report.index') }}?dana=' +
                                data.dana + '&bulan=' + data.bulan;
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

                $.ajax({
                    type: 'POST',
                    url: '{{ route('getReport') }}',
                    data: {
                        _token: _token,
                        dana: dana,
                        bulan: bulan
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            window.location.href = '{{ route('report.index') }}?dana=' +
                                data.dana + '&bulan=' + data.bulan;
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });

            });
        });
    </script>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush
