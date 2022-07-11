<div class="page">
    <div class="row">
        <div class="col">
            <button type="button" class="md-btn md-raised m-b-sm blue" role="button" onclick="tampilData()">
                <i class=" bi bi-plus-circle"></i> DATA
            </button>
            <button type="button" class="md-btn md-raised m-b-sm blue" role="button" data-toggle="modal"
                data-target="#Tambah">
                <i class="bi bi-plus-circle"></i> TAMBAH
            </button>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col">
            <form action="{{ route('pptk.store') }}" method="POST">
                @csrf
                {{-- @dd($pptk) --}}
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="row">
                    <div class="col">
                        <label for="pptk">PENANGGUNG JAWAB</label>
                        <select class="form-control custom-select" id="pptk" name="pptk">
                            <option value="">Pilih PENANGGUNG JAWAB</option>
                            @foreach ($Userpptk as $up)
                                <option value="{{ $up->id }}"
                                    {{ $pptk == null ? '' : ($pptk->user_p_p_t_k_id == $up->id ? 'selected' : '') }}>
                                    {{ $up->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <button type="submit" class="md-btn md-raised m-b-sm blue mt-2" role="button">
                            SIMPAN
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambah -->
<div class="modal fade" id="Tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data PPTK</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPPTK" action="{{ route('UserPPTK.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">NAMA</label>
                        <input type="text" class="form-control" id="nama" name="nama" required autofocus>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="md-btn md-raised m-b-sm white" role="button"
                        data-dismiss="modal">Batal</button>
                    <button type="submit" class="md-btn md-raised m-b-sm blue addPPTK" role="button">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('admin.entry.page.pptmodal')
@push('script')
    <script>
        function tampilData() {
            $('#showdata').modal('show');
            const datatablesSimple = document.getElementById('table-data');
            if (datatablesSimple) {
                new DataTable(datatablesSimple);
            }
        }
        $.validator.setDefaults({
            submitHandler: function() {
                $(form).submit();
            }
        });

        $(document).ready(function() {
            $("#addPPTK").validate({
                rules: {
                    nama: {
                        required: true,
                    },
                    nip: {
                        required: true,
                        minlength: 3
                    },
                },
                messages: {
                    nama: {
                        minlength: "Tulis nama anda!"
                    },
                    nip: {
                        minlength: "Masukan nomor NIP dengan benar!"
                    },
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });

        });
    </script>
@endpush
