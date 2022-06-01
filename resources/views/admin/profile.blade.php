@extends('template.main')

@section('content')
    <div ui-view class="app-body" id="view">

        <!-- ############ PAGE START-->

        <div class="item">
            <div class="item-bg">
                <img src="{{ url('storage/uploads') . '/' . $user->foto }}" class="blur opacity-3">
            </div>
            <div class="p-a-md">
                <div class="row m-t">
                    <div class="col-sm-7">
                        <a href class="pull-left m-r-md">
                            <span class="avatar w-96">
                                <img src="{{ url('storage/uploads') . '/' . $user->foto }}">
                                <i class="on b-white"></i>
                            </span>
                        </a>
                        <div class="clear m-b">
                            <h3 class="m-0 m-b-xs">{{ $user->nama_operator }}</h3>
                            <p class="text-muted"><span class="m-r">{{ $user->nama_SKPD }}</span>
                            </p>
                            <p class="text-muted"><i class="fa fa-phone"></i><span class="m-r">
                                    {{ $user->no_kantor }}</span>
                                <small><i class="fa fa-map-marker m-r-xs"></i>{{ $user->alamat_kantor }}</small>
                            </p>
                            <div class="block clearfix m-b">
                            </div>
                            <a href
                                class="btn btn-sm warn btn-rounded m-b">{{ $user->isAdmin == 1 ? 'Admin' : 'Operator' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dker p-x">
            <div class="row">
                <div class="col-sm-6 push-sm-6">
                    <div class="p-y text-center text-sm-right">
                        <a href class="inline p-x text-center">
                            <span class="h4 block m-0">{{ $kegiatan ?? 0 }}</span>
                            <small class="text-xs text-muted">SUB KEGIATAN</small>
                        </a>
                        <a href class="inline p-x b-l b-r text-center">
                            <span class="h4 block m-0">{{ $melapor ?? 0 }}</span>
                            <small class="text-xs text-muted">SELESAI MELAPOR</small>
                        </a>
                        <a href class="inline p-x text-center">
                            <span class="h4 block m-0">{{ $anggaran ? \FormatUang::format($anggaran) : 0 }}</span>
                            <small class="text-xs text-muted">ANGGARAN TOTAL</small>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 pull-sm-6">
                    <div class="p-y-md clearfix nav-active-primary">
                        <ul class="nav nav-pills nav-sm">
                            <li class="nav-item active">
                                <a class="nav-link" href data-toggle="tab" data-target="#tab_4">Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="padding">
            <div class="row">
                <div class=" col-md col-sm col-lg">
                    <div class="tab-content">
                        <div class="tab-pane p-v-sm active" id="tab_4">
                            <div class="box">
                                <div class="box-header">
                                    <h2>Update data profil</h2>
                                    <small>Silahkan dikosongi jika tidak ingin diupdate datanya.</small>
                                </div>
                                <div class="box-divider m-0"></div>
                                <div class="box-body p-v-md">
                                    <form action="{{ url('/profil/update') . '/' . $user->id }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row row-sm mb-2">
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="kode_skpd">Kode SKPD</label>
                                                <input type="text" class="form-control" id="kode_skpd" name="kode_skpd"
                                                    value="{{ $user->kode_SKPD }}" readonly>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="nama_skpd">Nama SKPD</label>
                                                <input type="text" class="form-control" id="nama_skpd" name="nama_skpd"
                                                    value="{{ $user->nama_SKPD }}">
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="nama_kpa">Nama KPA</label>
                                                <input type="text" class="form-control" id="nama_kpa" name="nama_kpa"
                                                    value="{{ $user->nama_KPA }}">
                                            </div>
                                        </div>
                                        <div class="row row-sm mb-2">
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="nama_operator">Nama Operator</label>
                                                <input type="text" class="form-control" id="nama_operator"
                                                    name="nama_operator" value="{{ $user->nama_operator }}"
                                                    placeholder="Nama Operator">
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="no_hp">Nomor Operator</label>
                                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                                    value="{{ $user->no_hp }}" placeholder="No Hp">
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="no_kantor">Nomor Kantor</label>
                                                <input type="text" class="form-control" id="no_kantor" name="no_kantor"
                                                    value="{{ $user->no_kantor }}" placeholder="No Kantor">
                                            </div>
                                        </div>
                                        <div class="row row-sm">
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username"
                                                    value="{{ $user->username }}" placeholder="Username" readonly>
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="password">Password</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Password">
                                            </div>
                                            <div class="col-md-4 col-lg-4 col-xs-4">
                                                <label for="foto">Foto</label>
                                                <input type="file" class="form-control" name="foto"
                                                    placeholder="Foto Profil">
                                                <small class="text-danger">Max file 1MB</small>
                                            </div>
                                        </div>
                                        <button type="submit" class="md-btn md-raised m-b-sm w-xs indigo"
                                            role="button">SIMPAN</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ############ PAGE END-->

    </div>
@endsection
