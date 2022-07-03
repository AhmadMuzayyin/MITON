@extends('template.main')


@section('content')
<div ui-view class="app-body" id="view">
    <!-- ############ PAGE START-->
    {{-- @dd(session()->get('pak_id')) --}}
    <div class="padding">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h1>DATA [SUB KEGIATAN]</h1>
                    </div>
                    <div class="box-body">
                        @if (session()->get('kondisi') == 1)
                        <div class="table-responsive">
                            <ul>
                                <li class="text-danger">Pastikan data SUB KEGIATAN sudah terinput semua!
                                </li>
                                <li class="text-danger">Inputkan total anggaran, bukan tambahan
                                    anggaran PAK saat ini!
                                </li>
                                <li class="text-danger">Inputkan semua Perubahan Anggaran, jika lebih dari 10
                                    dilanjut dengan next dan mengisi Perubahan Angggaran lalu klik simpan!
                                </li>
                            </ul>
                            <form action="{{ route('anggaran.perubahanstore') }}">
                                {{-- <form> --}}
                                @csrf
                                <table class="table" id="table-anggaran">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>SUB KEGIATAN</th>
                                            <th>ANGGARAN SEBELUMNYA</th>
                                            <th>ANGGARAN SEKARANG</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($anggaran as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ \FormatUang::format($item->anggaran) }}</td>
                                            <td>
                                                <input type="text" name="{{ $item->activity_id }}" value="{{ $item->anggaran }}">
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <button type="submit" class="md-btn md-raised m-b-sm w-xs blue AddPerubahan" role="button" {{ session()->get('kondisi') == 1 ? '' : 'disabled' }}>SIMPAN</button>
                            </form>
                        </div>
                        @endif
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
        var table = $("#table-anggaran").DataTable();
        $('.AddPerubahan').click(function(e) {
            e.preventDefault();
            var _token = $("input[name='_token']").val();
            var data = table.$('input').serializeArray();
            var Url = $(this).parents('form').attr('action');
            $.ajax({
                type: 'POST',
                url: Url,
                data: {
                    _token: _token,
                    data: data
                },
                success: function(data) {
                    if ($.isEmptyObject(data.error)) {
                        location.reload();
                    } else {
                        printErrorMsg(data.error);
                    }
                }
            });
        })
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
                        console.log(data.error);
                        location.reload();
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