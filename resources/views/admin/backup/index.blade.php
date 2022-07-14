@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [BACKUP DATABASE]</h1>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table text-center" id="table">
                                    <thead>
                                        <tr>
                                            <th>NO</th>
                                            <th>NAMA</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @dd($s->activity) --}}
                                        @foreach (array_slice($data, 2) as $value)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $value }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <form action="{{ url('/backup/download') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="file" value="{{ $value }}">
                                                            <button type="submit"
                                                                class="md-btn md-raised m-b-sm indigo"role="button">
                                                                <i class="bi bi-file-arrow-down-fill"></i>
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
