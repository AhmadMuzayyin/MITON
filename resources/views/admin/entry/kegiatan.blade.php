@extends('template.main')


@section('content')
<div ui-view class="app-body" id="view">
    <!-- ############ PAGE START-->
    {{-- @dd(session()->get('pak_id')) --}}
    <div class="padding">
        @if ($page == false)
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h1>DATA [SUB KEGIATAN]</h1>
                    </div>
                    <div class="box-body">
                        @if (Auth()->user()->isAdmin == false)
                        @foreach ($aktif as $item)
                        @if ($item->status != 0)
                        @if (session()->get('kondisi') == 0)
                        <a href="{{ route('activity.create') }}" class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white" role="button">TAMBAH</a>
                        @endif
                        @else
                        <div class="alert alert-danger" role="alert">
                            Inputan dinonaktifkan, silahkan hubungi admin!
                        </div>
                        @endif
                        @endforeach
                        @else
                        <a href="{{ route('Activity.export') }}" class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white" role="button">EXPORT</a>
                        @endif
                        <div class="table-responsive">
                            <table class="table" id="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NOMOR REKENING</th>
                                        <th>SUB KEGIATAN</th>
                                        <th>ANGGARAN</th>
                                        <th>DANA</th>
                                        <th>KETERANGAN</th>
                                        @if (Auth()->user()->isAdmin == false)
                                        <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->rek }}</td>
                                        <td>{{ $k->kegiatan }}</td>
                                        <td id="tdanggara">{{ \FormatUang::format($k->anggaran) }}
                                        </td>
                                        <td>{{ $k->sumber_dana->nama }}</td>
                                        <td>{{ $k->keterangan }}</td>
                                        @if (Auth()->user()->isAdmin == false)
                                        <td>
                                            @foreach ($aktif as $item)
                                            @if ($item->status != 0)
                                            <div class="btn-group">
                                                <form action="{{ route('activity.edit', $k->activity_id) }}" method="GET" class=" d-inline-block">
                                                    <button type="submit" class="md-btn md-raised m-b-sm blue" role="button" style="border: 0px">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('activity.destroy', $k->activity_id) }}" class=" d-inline-block mx-2">
                                                    @csrf
                                                    <button type="button" class="md-btn md-raised m-b-sm red deleteActivity" role="button" style="border: 0px">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @endif
                                            @endforeach
                                        </td>
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @elseif($page == 'edit')
        @include('admin.entry.page.kegiatanedit')
        @elseif($page == 'create')
        @include('admin.entry.page.kegiatancreate')
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
        $(".deleteActivity").click(function(e) {
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
                        location.reload();
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
    });

    $(document).ready(function() {
        $(".updateActivity").click(function(e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var id = $("input[name='id']").val();
            var rek = $("input[name='rek']").val();
            var dana = document.getElementById("dana").value;
            var subkegiatan = $("input[name='subkegiatan']").val();
            var pengadaan = document.getElementById("pengadaan").value;
            var anggaran = $("input[name='anggaran']").val();
            var kondisi = $("input[name='kondisi']").val();
            var ag_id = $("input[name='ag_id']").val();
            var pelaksanaan = document.getElementById("pelaksanaan").value;
            var kegiatan = $("input[name='kegiatan']").val();
            var laporan = [];
            var program = $('form input[type=radio]:checked').val();
            var Url = $(this).parents('form').attr('action');
            $(':checkbox:checked').each(function(i) {
                laporan[i] = $(this).val();
            });

            $.ajax({
                type: 'POST',
                url: '{{ route("kegiatan.up") }}',
                data: {
                    _token: _token,
                    id: id,
                    rek: rek,
                    dana: dana,
                    subkegiatan: subkegiatan,
                    pengadaan: pengadaan,
                    anggaran: anggaran,
                    kondisi: kondisi,
                    pelaksanaan: pelaksanaan,
                    kegiatan: kegiatan,
                    laporan: laporan,
                    program: program,
                    ag_id: ag_id
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        console.log(data);
                        // window.location.href =
                        //     '{{ route("activity.index") }}'
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        });
    });

    $.validator.setDefaults({
        submitHandler: function() {
            $(form).submit();
        }
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