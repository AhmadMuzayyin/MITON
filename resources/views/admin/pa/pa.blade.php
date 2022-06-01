@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [PENGGUNA ANGGARAN]</h1>
                        </div>
                        <div class="box-body">
                            <form action="{{ route('pa.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <label for="nip">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip"
                                            value="{{ $data == null ? '' : $data->NIP }}">
                                    </div>
                                    <div class="col">
                                        <label for="jabatan">JABATAN</label>
                                        <input type="text" class="form-control" id="jabatan" name="jabatan"
                                            value="{{ $data == null ? '' : $data->jabatan }}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <label for="nama">NAMA PENGGUNA ANGGARA (PA)</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ $data == null ? '' : $data->nama }}">
                                    </div>
                                    <div class="col" style="margin-top: 3.1%">
                                        <button type="submit"
                                            class="md-btn md-raised m-b-sm w-xs blue text-decoration-none updateActivity"
                                            role="button">SIMPAN</button>
                                        <button type="reset" role="button"
                                            class="md-btn md-raised m-b-sm w-xs orange text-decoration-none text-white">RESET</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ############ PAGE END-->
    </div>
@endsection
