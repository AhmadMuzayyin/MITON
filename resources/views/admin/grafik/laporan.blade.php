@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [LAPORAN]</h1>
                        </div>
                        <div class="box-body">
                            <div class="table-resnponsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <th>NO</th>
                                        <th>BULAN</th>
                                        <th>TANGGAL MELAPOR</th>
                                        <th>STATUS</th>
                                    </thead>
                                    <tbody>
                                        @if ($data)
                                            @foreach ($data as $key => $value)
                                                {{-- @dd($key) --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ strtoupper(\FormatUang::getbulan($key)) }}</td>
                                                    <td>{{ \FormatUang::getupdate($value) }}</td>
                                                    <td>
                                                        @foreach ($value as $status)
                                                            @if ($status->status == 1)
                                                            <button class="btn btn-fw btn-sm primary">MELAPOR</button>
                                                            @else
                                                            <button class="btn btn-fw btn-sm danger">TIDAK MELAPOR</button>
                                                            @endif
                                                        @endforeach
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
            <!-- ############ PAGE END-->
        </div>
    @endsection

    @push('script')
        <script>
            $(document).ready(function() {
                $(".table").DataTable();
            });
        </script>
    @endpush
