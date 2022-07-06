<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="box">
            <div class="box-header">
                <a href="{{ route('activity.index') }}" class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white" role="button">View</a>
            </div>
            <div class="box-body">
                <h5>Form Entry</h5>
                <form id="addActivity" action="{{ route('activity.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="pak_id" value="{{ session()->get('pak_id') }}">
                    <div class="row">
                        <div class="col-md -col-sm col-lg">
                            <label for="rek">NOMOR REKENING</label>
                            <small class="text-danger">Mohon diisi dengan lengkap dan benar</small>
                            <input type="text" class="form-control" id="rek" name="rek" placeholder="Contoh: 4.01.03.20.2.05.01" required autofocus>
                        </div>
                        <div class="col-md -col-sm col-lg">
                            <label for="dana">SUMBER DANA</label>
                            <select class="form-control" id="dana" name="dana" required>
                                <option value="">---PILIH SUMBER DANA---</option>
                                <option value="1">APBD Kabupaten Pamekasan</option>
                                <option value="2">APBD Provinsi</option>
                                <option value="3">APBN</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md col-sm col-lg">
                            <label for="subkegiatan">NAMA SUB KEGIATAN</label>
                            <input type="text" class="form-control" name="subkegiatan" required>
                        </div>
                        <div class="col-md col-sm col-lg">
                            <label for="pengadaan">JENIS PENGADAAN</label>
                            <select class="form-control" name="pengadaan" id="pengadaan" onchange="select()" required>
                                <option value="">---PILIH JENIS PENGADAAN---</option>
                                <option value="1">Konstruksi</option>
                                <option value="2">Barang</option>
                                <option value="3">Konsultansi</option>
                                <option value="4">Jasa Lainnya</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md col-sm col-lg">
                            <label for="anggaran">ANGGARAN</label>
                            <small class="text-info">Ditulis tanpa titik dan koma</small>
                            <input type="text" class="form-control" name="anggaran" required>
                            <input type="hidden" name="kondisi" value="{{ session()->get('kondisi') }}">
                        </div>
                        <div class="col-md col-sm col-lg">
                            <label for="pelaksanaan">METODE PELAKSANAAN</label>
                            <select class="form-control" name="pelaksanaan" id="pelaksanaan" required>
                                <option value="">---PILIH METODE PELAKSANAAN---</option>
                                <option id="opt" value="1">Tender</option>
                                <option value="2">Penunjukan Langsung</option>
                                <option value="3">Pengadaan Langsung</option>
                                <option value="4">ePurchasing</option>
                                <option value="5">Swakelola</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label for="kegiatan">BENTUK KEGIATAN</label>
                            <input type="text" class="form-control" name="kegiatan" required>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="laporan">LAPORAN</label>
                                    <div class="lpError"></div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck" name="laporan[]" value="dau">
                                            <label class="form-check-label" for="gridCheck">
                                                DAU
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck" name="laporan[]" value="dak">
                                            <label class="form-check-label" for="gridCheck">
                                                DAK
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="gridCheck" name="laporan[]" value="dbhc">
                                            <label class="form-check-label" for="gridCheck">
                                                DBHC
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="program">PROGRAM PRIORITAS BUPATI</label>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="program" id="gridRadios1" value="Ya" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="program" id="gridRadios1" value="Tidak" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Tidak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="submit" class="md-btn md-raised m-b-sm w-xs blue text-decoration-none" role="button">SIMPAN</button>
                            <button type="reset" class="md-btn md-raised m-b-sm w-xs orange text-decoration-none text-white" role="button">RESET</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#addActivity").validate({
            rules: {
                subkegiatan: "required",
                anggaran: {
                    required: true,
                    minlength: 7
                },
                kegiatan: "required",
                rek: {
                    required: true,
                    minlength: 5
                },
                "laporan[]": {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                rek: {
                    minlength: "NOMOR REKENIK minimal 5 digit!"
                },
                anggaran: {
                    minlength: "Minimal anggaran 1.000.000!"
                },
                "laporan[]": "Harap pilih min 1 laporan!"
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                // Add the `invalid-feedback` class to the error element
                error.addClass("invalid-feedback");
                let lp = document.getElementsByClassName("lpError");

                if (element.prop("type") === "checkbox") {
                    error.append(lp);
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass("is-invalid").removeClass("is-valid");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("is-valid").removeClass("is-invalid");
            }
        });

    });

    function select() {
        var select = document.getElementById('pengadaan');
        var option = select.options[select.selectedIndex];
        if (option.value == "3") {
            $('#opt').replaceWith(`<option value="6" >
                                       Seleksi
                                  </option>`);
        }
    }
    select();
</script>