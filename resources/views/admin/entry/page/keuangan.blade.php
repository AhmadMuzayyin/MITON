<div class="row">
    <div class="col-md col-sm col-lg">
        <label for="kegiatan">INPUT PERSENTASE TARGET KEGIATAN</label>
        <div class="progress">
            <div class="ppp progress-bar progress-bar-striped progress-bar-animated" id="kegiatan" role="progressbar"
                aria-valuenow="{{ !$target->isEmpty() ? $target[0]->progres : '' }}" aria-valuemin="0"
                aria-valuemax="100" style="width: {{ !$target->isEmpty() ? $target[0]->progres : '' }}%">
                {{ !$target->isEmpty() ? 'Complete' . $target[0]->progres . '%' : '' }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="row mt-2">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <label for="januari">JANUARI</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="januari"
                                name="januari" required
                                value="{{ !$target->isEmpty() ? $target[0]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="februari">FEBRUARI</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="februari"
                                name="februari" required
                                value="{{ !$target->isEmpty() ? $target[1]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="maret">MARET</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="maret"
                                name="maret" required value="{{ !$target->isEmpty() ? $target[2]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="april">APRIL</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="april"
                                name="april" required value="{{ !$target->isEmpty() ? $target[3]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="mei">MEI</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="mei"
                                name="mei" required value="{{ !$target->isEmpty() ? $target[4]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="juni">JUNI</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="juni"
                                name="juni" required value="{{ !$target->isEmpty() ? $target[5]->persentase : '' }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="juli">JULI</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="juli"
                                name="juli" required value="{{ !$target->isEmpty() ? $target[6]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="agustus">AGUSTUS</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="agustus"
                                name="agustus" required
                                value="{{ !$target->isEmpty() ? $target[7]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="september">SEPTEMBER</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="september"
                                name="september" required
                                value="{{ !$target->isEmpty() ? $target[8]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="oktober">OKTOBER</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="oktober"
                                name="oktober" required
                                value="{{ !$target->isEmpty() ? $target[9]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="november">NOVEMBER</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="november"
                                name="november" required
                                value="{{ !$target->isEmpty() ? $target[10]->persentase : '' }}">
                        </div>
                        <div class="col">
                            <label for="desember">DESEMBER</label>
                            <input type="text" class="form-control input-bulan" style="font-size: 90%" id="desember"
                                name="desember" required
                                value="{{ !$target->isEmpty() ? $target[11]->persentase : '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
