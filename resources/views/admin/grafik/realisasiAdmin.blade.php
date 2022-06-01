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
                                    <div class="row">
                                        <div class="col-md">
                                            <input type="text" name="kegiatan" id="kegiatan" class="kegiatan"
                                                value="50" readonly>
                                            <small>Target Kegiatan</small>
                                        </div>
                                        <div class="col-md">
                                            <input type="text" name="kegiatan" id="kegiatan" class="kegiatan"
                                                value="50" readonly>
                                            <small>Realisasi Kegiatan</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md">
                                    <p class="mx-3">Grafik Keuangan</p>
                                    <div class="row">
                                        <div class="col-md">
                                            <input type="text" name="keuangan" id="keuangan" class="keuangan"
                                                value="50" readonly>
                                            <small>Target Keuangan</small>
                                        </div>
                                        <div class="col-md">
                                            <input type="text" name="keuangan" id="keuangan" class="keuangan"
                                                value="50" readonly>
                                            <small>Realisasi Keuangan</small>
                                        </div>
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
    <script src="{{ url('assets/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{ url('assets/jquery-knob/excanvas.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ url('realFisik') }}",
                success: function(res) {
                    $(function() {
                        $(".kegiatan").knob({
                            'width': 100,
                            'height': 100
                        });
                    });
                }
            });
        });
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ url('realFisik') }}",
                success: function(res) {
                    $(".keuangan").knob({
                        'width': 100,
                        'height': 100
                    });
                }
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
                            window.location.href = '{{ route('realisasi') }}?dana=' +
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
