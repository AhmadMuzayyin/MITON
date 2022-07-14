@extends('template.main')
@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [GRAFIK REALISASI]</h1>
                        </div>
                        <div class="box-body">
                            <form>
                                <div class="row">
                                    @csrf
                                    {{-- @dd($bulan) --}}
                                    <div class="col-lg col-md col-sm">
                                        <label for="bulan">BULAN:</label>
                                        <select class="custom-select form-control" id="bulanSelect" name="bulanSelect">
                                            <option value="">Pilih Bulan</option>
                                            @foreach ($bulan as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $selected ? 'selected' : '' }}>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg col-md col-sm">
                                        <label for="bulan">SUMBER DANA:</label>
                                        <select class="custom-select form-control" id="danaSelect" name="danaSelect">
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
                            <div class="row mt-5">
                                <div class="col-md">
                                    <p class="mx-2">Grafik Kegiatan</p>
                                    <div class="row-col">
                                        <div class="row-cell">
                                            <div class="inline">
                                                <div class="target" data-redraw="true" id="PersenTK" data-percent="{{ $rakg['target'] }}">
                                                    <div class="persen" id="targetKegiatan">
                                                        {{ $rakg['target'] }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <small>
                                            <p>Target Kegiatan: {{ $rakg['target'] }}%</p>
                                            <p>Semua OPD: {{ count($rakg['opd']) }}</p>
                                        </small>
                                        <div class="row-cell">
                                            <div class="inline">
                                                <div class="realisasi" data-redraw="true" data-percent="{{ $rakg['opdmelapor'] }}">
                                                    <div class="persen">
                                                        {{ $rakg['opdmelapor'] }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <small>
                                            <p>Realisasi: {{ $rakg['opdmelapor'] }}%</p>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <p class="mx-3">Grafik Keuangan</p>
                                    <div class="row-col">
                                        <div class="row-cell">
                                            <div class="inline">
                                                <div class="target" data-redraw="true" data-percent="{{ $raku['persenTarget'] }}">
                                                    <div class="persen">
                                                        {{ $raku['persenTarget'] }}%
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <small>
                                            <p>Anggaran: Rp.{{ \FormatUang::format($raku['target'], 2) }}</p>
                                        </small>
                                        <div class="row-cell">
                                            <div class="inline">
                                                <div class="realisasi" data-redraw="true" data-percent="{{ $raku['persentase'] }}">
                                                    <div class="persen">
                                                        {{ $raku['persentase'] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <small>
                                            <p>Realisasi: Rp.{{ \FormatUang::format($raku['realanggaran']) }}</p>
                                        </small>
                                    </div>
                                </div>
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
    {{-- <script src="{{ url('assets/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{ url('assets/jquery-knob/excanvas.js') }}"></script> --}}
    <script src="{{ url('assets/libs/jquery/jquery.easy-pie-chart/dist/jquery.easypiechart.fill.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".target").easyPieChart({
                lineWidth: 5,
                trackColor: 'transparent',
                barColor: '#fcc100',
                scaleColor: 'transparent',
                size: 100,
                scaleLength: 0
            });
            $(".realisasi").easyPieChart({
                lineWidth: 5,
                trackColor: 'transparent',
                barColor: '#FA5661',
                scaleColor: 'transparent',
                size: 100,
                scaleLength: 0
            });
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
                            window.location.href = '{{ route('realisasi') }}?dana=' +
                                data.dana + '&bulan=' + data.bulan;
                        } else {
                            toastr.options =
                            {
                                "progressBar" : true
                            }
                            toastr.error(data.error, "Error");
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
                            window.location.href = '{{ route('realisasi') }}?dana=' +
                                data.dana + '&bulan=' + data.bulan;
                        } else {
                            toastr.options =
                            {
                                "progressBar" : true
                            }
                            toastr.error(data.error, "Error");
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
        .persen{
            position: fixed;
            margin: 2.7%
        }
    </style>
@endpush
