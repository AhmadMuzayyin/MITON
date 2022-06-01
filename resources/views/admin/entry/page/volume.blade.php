<div class="page">
    <div class="row">
        <div class="col">
            <form action="{{ route('volume.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $data->id }}">
                <div class="row">
                    <div class="col">
                        <label for="volume">VOLUME</label>
                        <input type="number" class="form-control" id="volume" name="volume" placeholder="Volume"
                            value="{{ $volume == true ? $volume->volume : '' }}" required autofocus>
                    </div>
                    <div class="col">
                        <label for="satuan">SATUAN</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan"
                            value="{{ $volume == true ? $volume->satuan : '' }}" required>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col mx-auto">
                        <button type="submit" class="md-btn md-raised m-b-sm blue addVolume"
                            role="button">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        // $(document).ready(function() {
        //     $(".addVolume").click(function(e) {
        //         e.preventDefault();
        //         var _token = $("input[name='_token']").val();
        //         var id = $("input[name='id']").val();
        //         var volume = $("input[name='volume']").val();
        //         var satuan = $("input[name='satuan']").val();
        //         var Url = $(this).parents('form').attr('action');
        //         $.ajax({
        //             type: 'POST',
        //             url: Url,
        //             data: {
        //                 _token: _token,
        //                 id: id,
        //                 volume: volume,
        //                 satuan: satuan
        //             },
        //             success: function(data) {
        //                 if ($.isEmptyObject(data.error)) {
        //                     // window.setTimeout(function() {
        //                     //     location.reload();
        //                     // }, 1000);
        //                 } else {
        //                     printErrorMsg(data.error);
        //                 }
        //             }
        //         });

        //     });
        // });
    </script>
@endpush
