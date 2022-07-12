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
                            <a href="{{ route('user.index') }}" class="md-btn md-raised m-b-sm w-xs blue" role="button">View</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ route('user.store') }}" method="POST">
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
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection