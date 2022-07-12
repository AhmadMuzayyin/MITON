@extends('template.main')


@section('content')
<div ui-view class="app-body" id="view">
    <!-- ############ PAGE START-->
    <div class="padding">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h1>DATA [OPD]</h1>
                    </div>
                    <div class="box-body">
                        <a href="{{ route('user.create') }}" class="md-btn md-raised m-b-sm w-xs blue" role="button">Tambah</a>
                        <a href="{{ route('user.export') }}" class="md-btn md-raised m-b-sm w-xs blue" role="button">EXPORT</a>
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>KODE SKPD</th>
                                        <th>NAMA SKPD</th>
                                        <th>OPERATOR</th>
                                        <th>KPA</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->kode_SKPD }}</td>
                                        <td>{{ $s->nama_SKPD }}</td>
                                        <td>{{ $s->nama_operator }}</td>
                                        <td>{{ $s->nama_KPA }}</td>
                                        <td>
                                            <form action="{{ route('user.edit', $s->id) }}" method="GET" class="d-inline-block">
                                                <button type="submit" class="md-btn md-raised m-b-sm blue" role="button" style="border: 0px">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('user.destroy', $s->id) }}" class="d-inline-block" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="md-btn md-raised m-b-sm red deleteUser" role="button" style="border: 0px">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
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

    $(document).ready(function() {
        $("#deleteUser").click(function(e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var Url = $(this).parents('form').attr('action');
            $.ajax({
                type: 'GET',
                url: Url,
                data: {
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        toastr.options =
                            {
                                "progressBar" : true
                            }
                            toastr.success("Berhasil mengapus data OPD!", "Success");
                        window.setTimeout(function() {
                            location.reload();
                        }, 1000);
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
@endpush