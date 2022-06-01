<!-- aside -->
<div id="aside" class="app-aside modal nav-dropdown">
    <!-- fluid app aside -->
    <div class="left navside dark dk" data-layout="column">
        <div class="navbar no-radius">
            <!-- brand -->
            <a class="navbar-brand">
                <div ui-include="'{{ url('assets/images/logo.svg') }}'"></div>
                <img src="{{ url('assets/images/logo.png') }}" alt="." class="hide">
                <span class="hidden-folded inline">MITON</span>
            </a>
            <!-- / brand -->
        </div>
        <div class="hide-scroll" data-flex>
            <nav class="scroll nav-light">

                @if (Auth()->user()->isAdmin == 1)
                <ul class="nav" ui-nav>

                    <li>
                        <a onclick="window.location.href = '{{ url('/dashboard') }}'">
                            <span class="nav-icon">
                                <i class="bi bi-house-fill"></i>
                            </span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-header hidden-folded">
                        <small class="text-muted">Main</small>
                    </li>

                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                            </span>
                            <span class="nav-text">Entry</span>
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a onclick="window.location.href = '{{ route('user.index') }}'">
                                    <span class="  nav-text">OPD</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('activity.index') }}'">
                                    <span class="nav-text">SUB KEGIATAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('schedule.index') }}'">
                                    <span class="  nav-text">SCHEDULE</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('report.index') }}'">
                                    <span class="  nav-text">REALISASI</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="bi bi-clipboard-data"></i>
                            </span>
                            <span class="nav-text">Report</span>
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a onclick="window.location.href = '{{ route('rekap') }}'">
                                    <span class="  nav-text">REKAPITULASI</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('realisasi') }}'">
                                    <span class="  nav-text">REALISASI ADMIN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('arsip') }}'">
                                    <span class="nav-text">ARSIP RFK</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('pengadaan') }}'">
                                    <span class="  nav-text">GRAFIK PENGADAAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('sebaran') }}'">
                                    <span class="  nav-text">GRAFIK SEBARAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('sumber-dana') }}'">
                                    <span class="  nav-text">SUMBER DANA</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('pelaksanaan') }}'">
                                    <span class="  nav-text">PELAKSANAAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('laporan') }}'">
                                    <span class="  nav-text">LAPORAN</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="bi bi-printer-fill"></i>
                            </span>
                            <span class="nav-text">Print</span>
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a onclick="window.location.href = '{{ route('print.DAU') }}'">
                                    <span class="  nav-text">DAU</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.DAK') }}'">
                                    <span class="  nav-text">DAK</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.DBHC') }}'">
                                    <span class="  nav-text">DBHC</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.kontruksi') }}'">
                                    <span class="nav-text">KONTRUKSI</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.barang') }}'">
                                    <span class="  nav-text">BARANG</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.konsultasi') }}'">
                                    <span class="  nav-text">KONSULTANSI</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.jasa') }}'">
                                    <span class="  nav-text">JASA LAINNYA</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.prioritas') }}'">
                                    <span class="  nav-text">PRIORITAS</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="bi bi-gear-fill"></i>
                            </span>
                            <span class="nav-text">Setting</span>
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a onclick="window.location.href = '{{ route('pak.index') }}'">
                                    <span class="  nav-text">TAHUN PAK</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('pa.index') }}'">
                                    <span class="  nav-text">PA</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '#'">
                                    <span class="nav-text">BACKUP DATA</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('activation.index') }}'">
                                    <span class="nav-text">AKTIFASI</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
                @else
                <ul class="nav" ui-nav>

                    <li>
                        <a onclick="window.location.href = '{{ url('/dashboard') }}'">
                            <span class="nav-icon">
                                <i class="bi bi-house-fill"></i>
                            </span>
                            <span class="nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-header hidden-folded">
                        <small class="text-muted">Main</small>
                    </li>

                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                            </span>
                            <span class="nav-text">Entry</span>
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a onclick="window.location.href = '{{ route('activity.index') }}'">
                                    <span class="nav-text">SUB KEGIATAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('schedule.index') }}'">
                                    <span class="  nav-text">SCHEDULE</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('report.index') }}'">
                                    <span class="  nav-text">REALISASI</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="bi bi-clipboard-data"></i>
                            </span>
                            <span class="nav-text">Report</span>
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a onclick="window.location.href = '{{ route('rekap') }}'">
                                    <span class="  nav-text">REKAPITULASI</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('arsip') }}'">
                                    <span class="nav-text">ARSIP RFK</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('pengadaan') }}'">
                                    <span class="  nav-text">GRAFIK PENGADAAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('sebaran') }}'">
                                    <span class="  nav-text">GRAFIK SEBARAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('sumber-dana') }}'">
                                    <span class="  nav-text">SUMBER DANA</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('pelaksanaan') }}'">
                                    <span class="  nav-text">PELAKSANAAN</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('laporan') }}'">
                                    <span class="  nav-text">LAPORAN</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a>
                            <span class="nav-caret">
                                <i class="bi bi-caret-down-fill"></i>
                            </span>
                            <span class="nav-icon">
                                <i class="bi bi-printer-fill"></i>
                            </span>
                            <span class="nav-text">Print</span>
                        </a>
                        <ul class="nav-sub">
                            <li>
                                <a onclick="window.location.href = '{{ route('print.DAU') }}'">
                                    <span class="  nav-text">DAU</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.DAK') }}'">
                                    <span class="  nav-text">DAK</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.DBHC') }}'">
                                    <span class="  nav-text">DBHC</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.kontruksi') }}'">
                                    <span class="nav-text">KONTRUKSI</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.barang') }}'">
                                    <span class="  nav-text">BARANG</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.konsultasi') }}'">
                                    <span class="  nav-text">KONSULTANSI</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.jasa') }}'">
                                    <span class="  nav-text">JASA LAINNYA</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.prioritas') }}'">
                                    <span class="  nav-text">PRIORITAS</span>
                                </a>
                            </li>
                            <li>
                                <a onclick="window.location.href = '{{ route('print.kendala') }}'">
                                    <span class="  nav-text">KENDALA</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
                @endif
            </nav>
        </div>
    </div>
</div>
<!-- end of aside -->