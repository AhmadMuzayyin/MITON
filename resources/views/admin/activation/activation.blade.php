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
                                <h1>DATA [INPUT AKTIFASI]</h1>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table" id="table">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>NAMA</th>
                                                <th>TANGGAL AKTIF</th>
                                                <th>TANGGAL NONAKTIF</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $s)
                                                {{-- @dd($s->activity) --}}
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $s->nama }}</td>
                                                    <td>{{ $s->aktif }}</td>
                                                    <td>{{ $s->nonaktif }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <form action="{{ route('activation.ganti') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="id" value="{{ $s->id }}">
                                                                <button type="submit"
                                                                    class="md-btn md-raised m-b-sm {{ $s->status == 0 ? 'red' : 'indigo' }}"
                                                                    role="button">
                                                                    <i
                                                                        class="bi {{ $s->status == 0 ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                                                </button>
                                                            </form>
                                                        </div>
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
