@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [SEBARAN KEGIATAN]</h1>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md col-lg">
                                    <div id="googleMap" style="width:100%;height:380px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ############ PAGE END-->
            </div>
        @endsection

        @push('script')
            <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{ ENV('MAP_KEY') }}">
            </script>
            <script>
                $(document).ready(function() {
                    $("#table").DataTable();
                });

                $(document).ready(function() {
                    $.ajax({
                        type: 'GET',
                        url: '{{ route('getSebaran') }}',
                        success: function(res) {
                            const lokasi = res.data.map(v => {
                                return {
                                    lat: parseFloat(v.latitude),
                                    long: parseFloat(v.longitude),
                                }
                            })
                            let map = new google.maps.Map(document.getElementById('googleMap'), {
                                zoom: 10,
                                center: new google.maps.LatLng(lokasi[0].lat, lokasi[0].long),
                                mapTypeId: google.maps.MapTypeId.ROADMAP
                            });
                            for (i = 0; i < lokasi.length; i++) {
                                marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(lokasi[i].lat, lokasi[i]
                                        .long),
                                    map: map
                                });
                            }
                        }
                    });
                });
            </script>
        @endpush
