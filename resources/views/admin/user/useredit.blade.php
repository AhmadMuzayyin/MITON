@extends('template.main')

@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-header">
                                <a href="{{ route('user.index') }}" class="md-btn md-raised m-b-sm w-xs blue"
                                    role="button">View</a>
                            </div>
                        </div>
                        <div class="box-body">
                            @foreach ($data as $d)
                                <form id="editOPD" action="{{ route('user.up') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $d->id }}">
                                    <div class="row mb-3">
                                        <div class="col-md col-sm col-lg">
                                            <label for="kode">KODE SKPD</label>
                                            <input type="text" class="form-control" id="kode" name="kode"
                                                placeholder="KODE SKPD" value="{{ $d->kode_SKPD }}">
                                        </div>
                                        <div class="col-md col-sm col-lg">
                                            <label for="skpd">NAMA SKPD</label>
                                            <input type="text" class="form-control" id="skpd" name="skpd"
                                                placeholder="NAMA SKPD" value="{{ $d->nama_SKPD }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md col-sm col-lg">
                                            <label for="nokantor">NOMOR TELEPON KANTOR</label>
                                            <input type="text" class="form-control" id="nokantor" name="nokantor"
                                                placeholder="NOMOR TELEPON KANTOR" value="{{ $d->no_kantor }}">
                                        </div>
                                        <div class="col-md col-sm col-lg">
                                            <label for="alamatkantor">ALAMAT KANTOR</label>
                                            <input type="text" class="form-control" id="alamatkantor" name="alamatkantor"
                                                placeholder="ALAMAT KANTOR" value="{{ $d->alamat_kantor }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md col-sm col-lg">
                                            <label for="namaoperator">NAMA OPERATOR</label>
                                            <input type="text" class="form-control" id="namaoperator" name="namaoperator"
                                                placeholder="NAMA OPERATOR" value="{{ $d->nama_operator }}">
                                        </div>
                                        <div class="col-md col-sm col-lg">
                                            <label for="nooperator">NO TELEPON OPERATOR</label>
                                            <input type="text" class="form-control" id="nooperator" name="nooperator"
                                                placeholder="NO TELEPON OPERATOR" value="{{ $d->no_hp }}">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md col-sm col-lg">
                                            <label for="username">USERNAME</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="USERNAME" value="{{ $d->username }}">
                                        </div>
                                        <div class="col-md col-sm col-lg">
                                            <label for="password">PASSWORD</label>
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="PASSWORD">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md col-sm col-lg">
                                            <label for="kpa">NAMA KPA</label>
                                            <input type="text" class="form-control" id="kpa" name="kpa"
                                                placeholder="NAMA KPA" value="{{ $d->nama_KPA }}">
                                        </div>
                                        <div class="col-md col-sm col-lg">
                                            <label for="level">LEVEL</label>
                                            <select class="form-control" id="level" name="level">
                                                <option value="">Pilih Level User
                                                </option>
                                                <option value="1" {{ $d->isAdmin == 1 ? 'selected' : '' }}>Admin
                                                </option>
                                                <option value="0" {{ $d->isAdmin == 0 ? 'selected' : '' }}>
                                                    Operator
                                                </option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md col-sm col-lg mt-3">
                                            <button type="submit" class="md-btn md-raised m-b-sm w-xs blue"
                                                role="button">UPDATE</button>
                                            <!-- <button type="button" class="md-btn md-raised m-b-sm w-xs orange" role="button">RESET</button> -->
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
