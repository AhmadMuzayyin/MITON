@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            @if ($page == 'index')
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="box">
                            <div class="box-header">
                                <h1>DATA [SCHEDULE]</h1>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>REKENING</th>
                                                <th>NAMA KEGIATAN</th>
                                                <th>PROGRES SCHEDULE</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $s)
                                                {{-- @dd($s->activity) --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $s->rek }}</td>
                                                    <td>{{ $s->nama }}</td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-striped progress-bar-animated"
                                                                role="progressbar" aria-valuenow="{{ $s->persentase > 100 ? 100 : $s->persentase }}"
                                                                aria-valuemin="0" aria-valuemax="100"
                                                                style="width: {{ $s->persentase > 100 ? 100 : $s->persentase }}%">
                                                                @if ($s->persentase >= 100)
                                                                    Complete {{ $s->persentase > 100 ? 100 : $s->persentase }}%
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if (Auth()->user()->isAdmin != 1)
                                                            <form action="{{ route('schedule.edit', $s->id) }}">
                                                                <button type="submit" class="md-btn md-raised m-b-sm blue"
                                                                    role="button" style="border: 0px">
                                                                    <i class="bi bi-pencil-square"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="box">
                            <div class="box-header">

                                <div class="row">
                                    <div class="col-md col-sm col-lg my-2">
                                        <a href="{{ route('schedule.index') }}" class="md-btn md-raised m-b-sm blue"
                                            role="button">
                                            <i class="bi bi-arrow-left"></i> Kembali
                                        </a>
                                    </div>

                                    <div class="col-md col-sm col-lg my-2">
                                        <a href="{{ route('schedule.edit', $data->id) }}"
                                            class="md-btn md-raised m-b-sm blue" role="button">
                                            <i class="bi bi-geo-alt-fill"></i> LOKASI
                                        </a>
                                    </div>


                                    <div class="col-md col-sm col-lg my-2">
                                        <a href="{{ url('/schedule') . '/' . $data->id . '/edit/volume' }}"
                                            class="md-btn md-raised m-b-sm blue" role="button">
                                            <i class="bi bi-hourglass-split"></i> VOLUME
                                        </a>
                                    </div>


                                    <div class="col-md col-sm col-lg my-2 mr-md-5 mr-sm-auto">
                                        <a href="{{ url('/schedule') . '/' . $data->id . '/edit/pptk' }}"
                                            class="md-btn md-raised m-b-sm blue" role="button">
                                            <i class="bi bi-people-fill"></i> PENANGGUNG JAWAB
                                        </a>
                                    </div>


                                    <div class="col-md col-sm col-lg my-2">
                                        <a href="{{ url('/schedule') . '/' . $data->id . '/edit/target' }}"
                                            class="md-btn md-raised m-b-sm blue" role="button">
                                            <i class="bi bi-grid-1x2-fill"></i> TARGET
                                        </a>
                                    </div>
                                </div>

                            </div>

                            <div class="box-body">
                                <div class="card text-white text-center mb-3"
                                    style="max-width: 100em; max-height: 30em; background-color: #2E3E4E">
                                    <div class="card-body">
                                        <h1 style="margin-top: 25px; margin-bottom: 25px">{{ $data->activity->rek }}
                                            |
                                            {{ $data->activity->nama }}</h1>
                                    </div>
                                </div>
                                @if ($page == 'lokasi')
                                    @include('admin.entry.page.lokasi')
                                @elseif ($page == 'volume')
                                    @include('admin.entry.page.volume')
                                @elseif ($page == 'PPTK')
                                    @include('admin.entry.page.pptk')
                                @elseif ($page == 'target')
                                    @include('admin.entry.page.target')
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
