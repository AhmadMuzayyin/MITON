<div class="page">
    <form id="formID" action="{{ route('target.store') }}">
        @csrf
        <div class="row mb-3">
            <div class="col-md col-sm col-lg">
                <label for="kegiatan">INPUT NOMINAL TARGET KEUANGAN</label>
                <label for="kegiatan">(Anggaran: {{ \FormatUang::format($anggaran->anggaran) }})</label>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" id="kegiatan" role="progressbar"
                        aria-valuenow="{{ !$k->isEmpty() ? $k[0]->progres : '' }}" aria-valuemin="0"
                        aria-valuemax="100" style="width: {{ !$k->isEmpty() ? $k[0]->progres : '' }}%">
                        {{ !$k->isEmpty() ? 'Complete' . $k[0]->progres . '%' : '' }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mt-2">
                        <input type="hidden" name="target" id="target" value="{{ $data->activity->anggaran }}">
                        <input type="hidden" name="id" value="{{ $data->id }}">
                        <input type="hidden" name="ac" value="{{ $ac->activity_id }}">
                        <input type="hidden" name="pak" value="{{ $ac->activity->pak_id }}">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="januari">JANUARI</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="11" name="AC_januari" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[0]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[0]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="februari">FEBRUARI</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="12" name="AC_februari" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[1]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[1]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="marete">MARET</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="13" name="AC_maret" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[2]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[2]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="april">APRIL</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="14" name="AC_april" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[3]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[3]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="mei">MEI</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="15" name="AC_mei" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[4]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[4]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="juni">JUNI</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="16" name="AC_juni" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[5]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[5]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="juli">JULI</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="17" name="AC_juli" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[6]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[6]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="agustus">AGUSTUS</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="18" name="AC_agustus" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[7]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[7]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="september">SEPTEMBER</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="19" name="AC_september" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[8]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[8]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="oktober">OKTOBER</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="20" name="AC_oktober" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[9]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[9]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="november">NOVEMBER</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="21" name="AC_november" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[10]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[10]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                                <div class="col">
                                    <label for="desember">DESEMBER</label>
                                    <input type="{{ $k == null ? 'number' : 'text' }}" class="form-control"
                                        style="font-size: 85%" id="22" name="AC_desember" required
                                        value="{{ !$k->isEmpty() ? \FormatUang::format($k[11]->anggaran) : '' }}"
                                        {{ !$k->isEmpty() ? ($k[11]->month_id < date('n', strtotime($anggaran->created_at)) ? 'readonly' : '') : '' }}>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @if (session()->get('kondisi') == 0)
            @include('admin.entry.page.keuangan')
        @endif
        <div class="row mt-2">
            <div class="col">
                @foreach ($aktif as $item)
                    @if ($item->status == '1')
                        <button type="submit" class="md-btn md-raised m-b-sm blue addTarget"
                            role="button">SIMPAN</button>
                        <button type="submit"
                            class="md-btn md-raised m-b-sm orange text-white UpdateTarget">PERBARUI</button>
                    @else
                        <div class="alert alert-danger" role="alert">
                            Inputan dinonaktifkan, silahkan hubungi admin!
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </form>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            $(".addTarget").click(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var id = $("input[name='id']").val();

                var AC_januari = $("input[name='AC_januari']").val();
                var AC_februari = $("input[name='AC_februari']").val();
                var AC_maret = $("input[name='AC_maret']").val();
                var AC_april = $("input[name='AC_april']").val();
                var AC_mei = $("input[name='AC_mei']").val();
                var AC_juni = $("input[name='AC_juni']").val();
                var AC_juli = $("input[name='AC_juli']").val();
                var AC_agustus = $("input[name='AC_agustus']").val();
                var AC_september = $("input[name='AC_september']").val();
                var AC_oktober = $("input[name='AC_oktober']").val();
                var AC_november = $("input[name='AC_november']").val();
                var AC_desember = $("input[name='AC_desember']").val();

                var januari = $("input[name='januari']").val();
                var februari = $("input[name='februari']").val();
                var maret = $("input[name='maret']").val();
                var april = $("input[name='april']").val();
                var mei = $("input[name='mei']").val();
                var juni = $("input[name='juni']").val();
                var juli = $("input[name='juli']").val();
                var agustus = $("input[name='agustus']").val();
                var september = $("input[name='september']").val();
                var oktober = $("input[name='oktober']").val();
                var november = $("input[name='november']").val();
                var desember = $("input[name='desember']").val();
                var ac = $("input[name='ac']").val();

                let keuangan = {
                    "1": AC_januari,
                    "2": AC_februari,
                    "3": AC_maret,
                    "4": AC_april,
                    "5": AC_mei,
                    "6": AC_juni,
                    "7": AC_juli,
                    "8": AC_agustus,
                    "9": AC_september,
                    "10": AC_oktober,
                    "11": AC_november,
                    "12": AC_desember,
                };

                let target = {
                    "1": januari,
                    "2": februari,
                    "3": maret,
                    "4": april,
                    "5": mei,
                    "6": juni,
                    "7": juli,
                    "8": agustus,
                    "9": september,
                    "10": oktober,
                    "11": november,
                    "12": desember,
                };

                var Url = $(this).parents('form').attr('action');
                $.ajax({
                    type: 'POST',
                    url: Url,
                    data: {
                        _token: _token,
                        id: id,
                        ac: ac,
                        target: Object.entries(target),
                        keuangan: Object.entries(keuangan)

                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            toastr.options =
                            {
                                "progressBar" : true
                            }
                            toastr.success("Data target kegiatan dan keuangan berhasil disimpan!", "Success");
                            window.setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.options =
                            {
                                "progressBar" : true
                            }
                            toastr.error(data.error, "Error");
                        }
                    }
                });
            });
        });
        $(document).ready(function() {
            $(".UpdateTarget").click(function(e) {
                e.preventDefault();
                var _token = $("input[name='_token']").val();
                var id = $("input[name='id']").val();

                var AC_januari = $("input[name='AC_januari']").val();
                var AC_februari = $("input[name='AC_februari']").val();
                var AC_maret = $("input[name='AC_maret']").val();
                var AC_april = $("input[name='AC_april']").val();
                var AC_mei = $("input[name='AC_mei']").val();
                var AC_juni = $("input[name='AC_juni']").val();
                var AC_juli = $("input[name='AC_juli']").val();
                var AC_agustus = $("input[name='AC_agustus']").val();
                var AC_september = $("input[name='AC_september']").val();
                var AC_oktober = $("input[name='AC_oktober']").val();
                var AC_november = $("input[name='AC_november']").val();
                var AC_desember = $("input[name='AC_desember']").val();

                var januari = $("input[name='januari']").val();
                var februari = $("input[name='februari']").val();
                var maret = $("input[name='maret']").val();
                var april = $("input[name='april']").val();
                var mei = $("input[name='mei']").val();
                var juni = $("input[name='juni']").val();
                var juli = $("input[name='juli']").val();
                var agustus = $("input[name='agustus']").val();
                var september = $("input[name='september']").val();
                var oktober = $("input[name='oktober']").val();
                var november = $("input[name='november']").val();
                var desember = $("input[name='desember']").val();
                var ac = $("input[name='ac']").val();

                let keuangan = {
                    "1": AC_januari,
                    "2": AC_februari,
                    "3": AC_maret,
                    "4": AC_april,
                    "5": AC_mei,
                    "6": AC_juni,
                    "7": AC_juli,
                    "8": AC_agustus,
                    "9": AC_september,
                    "10": AC_oktober,
                    "11": AC_november,
                    "12": AC_desember,
                };

                let target = {
                    "1": januari,
                    "2": februari,
                    "3": maret,
                    "4": april,
                    "5": mei,
                    "6": juni,
                    "7": juli,
                    "8": agustus,
                    "9": september,
                    "10": oktober,
                    "11": november,
                    "12": desember,
                };

                var Url = $(this).parents('form').attr('action');
                $.ajax({
                    type: 'POST',
                    url: '{{ url('/target/update') }}',
                    data: {
                        _token: _token,
                        id: id,
                        ac: ac,
                        target: Object.entries(target),
                        keuangan: Object.entries(keuangan)

                    },
                    success: function(data) {
                        if ($.isEmptyObject(data.error)) {
                            toastr.options =
                            {
                                "progressBar" : true
                            }
                            toastr.success("Data target kegiatan dan keuangan berhasil diperbarui!", "Success");
                            window.setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.options =
                            {
                                "progressBar" : true
                            }
                            toastr.error(data.error, "Error");
                        }
                    }
                });
            });
        });
    </script>

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>
@endpush
