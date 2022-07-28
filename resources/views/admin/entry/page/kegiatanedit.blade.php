<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="box">
            <div class="box-header">
                <a href="{{ route('activity.index') }}"
                    class="md-btn md-raised m-b-sm w-xs blue text-decoration-none text-white" role="button">View</a>
            </div>
            <div class="box-body">
                <h5>Form Entry</h5>
                <form id="updateActivity">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="row">
                        <div class="col-md -col-sm col-lg">
                            <label for="rek">NOMOR REKENING</label>
                            <small class="text-danger">Mohon diisi dengan lengkap dan benar</small>
                            <input type="text" class="form-control" id="rek" name="rek"
                                placeholder="Contoh: 4.01.03.20.2.05.01" required autofocus value="{{ $data->rek }}">
                        </div>
                        <div class="col-md -col-sm col-lg">
                            <label for="dana">SUMBER DANA</label>
                            <select class="form-control" id="dana" name="dana" required>
                                <option value="">---PILIH SUMBER DANA---</option>
                                @foreach ($dana as $s)
                                    <option value="{{ $s->id }}"
                                        {{ $data->sumber_dana_id == $s->id ? 'selected' : '' }}>
                                        {{ $s->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md col-sm col-lg">
                            <label for="subkegiatan">NAMA SUB KEGIATAN</label>
                            <input type="text" class="form-control" name="subkegiatan" required
                                value="{{ $data->nama }}">
                        </div>
                        <div class="col-md col-sm col-lg">
                            <label for="pengadaan">JENIS PENGADAAN</label>
                            <select class="form-control" name="pengadaan" id="pengadaan" onchange="select()" required>
                                <option value="">---PILIH JENIS PENGADAAN---</option>
                                @foreach ($pengadaan as $pp)
                                    <option value="{{ $pp->id }}"
                                        {{ $data->pengadaan_id == $pp->id ? 'selected' : '' }}>
                                        {{ $pp->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md col-sm col-lg">
                            <label for="anggaran">ANGGARAN</label>
                            <small class="text-info">Ditulis tanpa titik dan koma</small>
                            <input type="text" class="form-control" name="anggaran" required
                                value="{{ session()->get('kondisi') == 0 ? $data->anggaran[0]->anggaran : $data->anggaran[1]->anggaran }}">
                            <input type="hidden" name="kondisi" value="{{ session()->get('kondisi') }}">
                            <input type="hidden" name="ag_id" value="{{ $data->anggaran[0]->id }}">
                        </div>
                        <div class="col-md col-sm col-lg">
                            <label for="pelaksanaan">METODE PELAKSANAAN</label>
                            <select class="form-control" name="pelaksanaan" id="pelaksanaan" required>
                                <option value="">---PILIH METODE PELAKSANAAN---</option>
                                @foreach ($pelaksanaan as $pl)
                                    <option value="{{ $pl->id }}"
                                        {{ $data->pelaksanaan_id == $pl->id ? 'selected' : '' }}>
                                        {{ $pl->nama }}
                                    </option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <label for="kegiatan">BENTUK KEGIATAN</label>
                            <input type="text" class="form-control" name="kegiatan" required
                                value="{{ $data->kegiatan }}">
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
                                            <input class="form-check-input laporancheck" type="checkbox" id="dau"
                                                name="laporan[]" value="dau"
                                                {{ $data->dau == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="dau">
                                                DAU
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input laporancheck" type="checkbox" id="dak"
                                                name="laporan[]" value="dak"
                                                {{ $data->dak == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="dak">
                                                DAK
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input laporancheck" type="checkbox" id="dbhc"
                                                name="laporan[]" value="dbhc"
                                                {{ $data->dbhc == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="dbhc">
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
                                    <label for="program">PROGRAM BUPATI</label>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="program" id="ya"
                                                value="Ya" {{ $data->program == 'Ya' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ya">
                                                Ya
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="program" id="tidak"
                                                value="Tidak" {{ $data->program == 'Tidak' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="tidak">
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
                            <button type="submit"
                                class="md-btn md-raised m-b-sm w-xs blue text-decoration-none updateActivity"
                                role="button">PERBARUI</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
