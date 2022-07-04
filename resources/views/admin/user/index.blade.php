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
                                            <form action="{{ route('user.destroy', $s->id) }}" class="d-inline-block">
                                                @csrf
                                                <button type="button" class="md-btn md-raised m-b-sm red deleteUser" role="button" style="border: 0px">
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
        @elseif ($page == 'edit')
        @include('admin.user.useredit')
        @else
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        <div class="box-header">
                            <a href="{{ route('user.index') }}" class="md-btn md-raised m-b-sm w-xs blue" role="button">View</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <form id="addOPD" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md col-sm col-lg">
                                    <label for="kode">KODE SKPD</label>
                                    <input type="text" class="form-control @error('kode') parsley-error @enderror" id="kode" name="kode" value="{{ old('kode') }}" placeholder="KODE SKPD">
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="skpd">NAMA SKPD</label>
                                    <input type="text" class="form-control @error('skpd') parsley-error @enderror" id="skpd" name="skpd" value="{{ old('skpd') }}" placeholder="NAMA SKPD">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md col-sm col-lg">
                                    <label for="nokantor">NOMOR TELEPON KANTOR</label>
                                    <input type="text" class="form-control @error('nokantor') parsley-error @enderror" id="nokantor" name="nokantor" value="{{ old('nokantor') }}" placeholder="NOMOR TELEPON KANTOR">
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="alamatkantor">ALAMAT KANTOR</label>
                                    <input type="text" class="form-control @error('alamatkantor') parsley-error @enderror" id="alamatkantor" name="alamatkantor" value="{{ old('alamatkantor') }}" placeholder="ALAMAT KANTOR">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md col-sm col-lg">
                                    <label for="namaoperator">NAMA OPERATOR</label>
                                    <input type="text" class="form-control @error('namaoperator') parsley-error @enderror" id="namaoperator" name="namaoperator" value="{{ old('namaoperator') }}" placeholder="NAMA OPERATOR">
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="nooperator">NO TELEPON OPERATOR</label>
                                    <input type="text" class="form-control @error('nooperator') parsley-error @enderror" id="nooperator" name="nooperator" value="{{ old('nooperator') }}" placeholder="NO TELEPON OPERATOR">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md col-sm col-lg">
                                    <label for="username">USERNAME</label>
                                    <input type="text" class="form-control @error('username') parsley-error @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="USERNAME">
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="password">PASSWORD</label>
                                    <input type="password" class="form-control @error('password')  @enderror" id="password" name="password" value="{{ old('password') }}" placeholder="PASSWORD">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md col-sm col-lg">
                                    <label for="kpa">NAMA KPA</label>
                                    <input type="text" class="form-control @error('kpa') parsley-error @enderror" id="kpa" name="kpa" value="{{ old('kpa') }}" placeholder="NAMA KPA">
                                </div>
                                <div class="col-md col-sm col-lg">
                                    <label for="level">LEVEL</label>
                                    <select class="form-control" id="level" name="level">
                                        <option value="">Pilih Level User</option>
                                        <option value="1">Admin</option>
                                        <option value="0">Operator</option>
                                    </select>

                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md col-sm col-lg mt-3">
                                    <button type="submit" class="md-btn md-raised m-b-sm w-xs blue" role="button">SIMPAN</button>
                                    <button type="button" class="md-btn md-raised m-b-sm w-xs orange" role="button">RESET</button>
                                </div>
                            </div>
                        </form>
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

    $(document).ready(function() {
        $(".deleteUser").click(function(e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var Url = $(this).parents('form').attr('action');
            $.ajax({
                type: 'DELETE',
                url: Url,
                data: {
                    _token: _token
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        window.setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
    });
</script>
@endpush