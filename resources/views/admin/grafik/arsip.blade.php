@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [ARSIP LAPORAN RFK]</h1>
                            {{-- @dd($item) --}}
                            <form action="">
                                @csrf
                                <div class="row">
                                    <div class="col-md col-sm col-lg">
                                        <select class="custom-select form-control" id="dana" name="dana">
                                            @foreach ($dana as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id != 1 ? ($item->id == $selected ? 'selected' : '') : 'selected' }}>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (Auth()->user()->isAdmin == 1)
                                        <div class="col-md col-sm col-lg">
                                            <select class="custom-select form-control" id="skpd" name="skpd">
                                                @foreach ($skpd as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == request()->get('skpd') ? 'selected' : '' }}>
                                                        {{ $item->nama_SKPD }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>BULAN</th>
                                            <th>COVER</th>
                                            <th>JADWAL</th>
                                            <th>RFK</th>
                                            <th>GRAFIK</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($data != '')
                                            @foreach ($data as $item)
                                                {{-- @dd($item['bulan'][0]->nama) --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ strtoupper($item['bulan'][0]->nama) }}</td>
                                                    <td>
                                                        <form action="{{ route('get.Cover') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item['bulan'][0]->id }}">
                                                            <input type="hidden" name="data"
                                                                value="{{ request()->get('data') ? request()->get('data') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">COVER</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('get.Jadwal') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item['bulan'][0]->id }}">
                                                            <input type="hidden" name="data"
                                                                value="{{ request()->get('data') ? request()->get('data') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">JADWAL</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('get.RFK') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item['bulan'][0]->id }}">
                                                            <input type="hidden" name="data"
                                                                value="{{ request()->get('data') ? request()->get('data') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">RFK</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('get.grafik') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="bulan"
                                                                value="{{ $item['bulan'][0]->id }}">
                                                            <input type="hidden" name="data"
                                                                value="{{ request()->get('data') ? request()->get('data') : 1 }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white"
                                                                role="button">GRAFIK</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
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
        $(document).ready(function() {
            $("#dana").change(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var dana = $(this).children("option:selected").val();
                var skpd = $("#skpd option:selected").val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get.arsip') }}',
                    data: {
                        _token: _token,
                        dana: dana,
                        skpd: skpd
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            window.location.href = '{{ url('arsip') }}?data=' + data
                                .dana + '&skpd=' + data.skpd
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
        });
        $(document).ready(function() {
            $("#skpd").change(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var skpd = $(this).children("option:selected").val();
                var dana = $("#dana option:selected").val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('get.arsip') }}',
                    data: {
                        _token: _token,
                        dana: dana,
                        skpd: skpd
                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            window.location.href = '{{ url('arsip') }}?data=' + data
                                .dana + '&skpd=' + data.skpd
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
        });
    </script>
@endpush
