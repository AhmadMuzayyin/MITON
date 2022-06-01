@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-6 col-md-8">
                    <div class="box">

                        <div class="box-header">
                            <h1>DATA [PAK]</h1>
                        </div>

                        <div class="box-body">
                            <button class="md-btn md-raised m-b-sm w-xs blue addPAK" id="addPAK"
                                role="button">TAMBAH</button>
                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>TAHUN PAK</th>
                                            <th>TANGGAL</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $s)
                                            {{-- @dd($s->lockpak) --}}
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $s->nama }}</td>
                                                <td>{{ $s->created_at }}</td>
                                                <td>

                                                    <form action="{{ route('pak.unlock') }}" method="POST"
                                                        class=" d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="sebelum" value="{{ $s->lockpak[1] }}">
                                                        <div class="btn-group">
                                                            <button
                                                                class="md-btn md-raised m-b-sm {{ $s->lockpak[0]->status == 0 ? 'pink' : 'pink' }}">
                                                                <i
                                                                    class="bi {{ $s->lockpak[0]->status == 0 ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                    <form action="{{ route('pak.unlock') }}" method="POST"
                                                        class=" d-inline-block">
                                                        @csrf
                                                        <input type="hidden" name="sesudah"
                                                            value="{{ $s->lockpak[1]->id }}">
                                                        <div class="btn-group">
                                                            <button
                                                                class="md-btn md-raised m-b-sm {{ $s->lockpak[1]->status == 0 ? 'indigo' : 'indigo' }}">
                                                                <i
                                                                    class="bi {{ $s->lockpak[1]->status == 0 ? 'bi-lock-fill' : 'bi-unlock-fill' }}"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                    <form action="{{ route('pak.destroy', $s->id) }}"
                                                        class=" d-inline-block">
                                                        <div class="btn-group">
                                                            <button class="md-btn md-raised m-b-sm red deletePAK">
                                                                <i class="bi bi-trash-fill"></i>
                                                            </button>
                                                        </div>
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
                <div class="col-sm-6 col-md-4 pakhtml">

                </div>
                {{-- end col 2 --}}
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

        $('.addPAK').click(function() {
            var html = `
                    <div class="box pak_html">
                        <div class="box-body">
                            <form action="{{ route('pak.store') }}" method="POST">
                                @csrf
                                  <div class="row">
                                      <div class="col">
                                          <label for="nama">TAHUN PAK</label>
                                          <input type="date" class="form-control" id="nama" name="nama" required>
                                      </div>
                                  </div>
                                  <div class="row mt-3">
                                      <div class="col">
                                          <button type="submit" class="md-btn md-raised m-b-sm w-xs blue" role="button">SIMPAN</button>
                                          <button type="button" class="md-btn md-raised m-b-sm w-xs white" id="btl" role="button">BATAL</button>
                                      </div>
                                  </div>
                            </form>
                        </div>
                    </div>
                    `;

            $('.pakhtml').append(html);
            document.getElementById('addPAK').disabled = true;
        });

        $('#btl').click(function() {
            $("div").remove(".pak_html");
        });

        $(document).ready(function() {
            $(".deletePAK").click(function(e) {
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
                            // window.setTimeout(function() {
                            //     location.reload();
                            // }, 1000);
                        } else {
                            printErrorMsg(data.error);
                        }
                    }
                });
            });
        });
    </script>
@endpush
