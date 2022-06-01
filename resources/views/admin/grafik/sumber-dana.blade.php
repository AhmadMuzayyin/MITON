@extends('template.main')


@section('content')
    <div ui-view class="app-body" id="view">
        <!-- ############ PAGE START-->
        <div class="padding">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h1>DATA [GRAFIK SUMBER DANA]</h1>
                        </div>
                        <div class="box-body">
                            <span class="justify-content-center">
                                <canvas id="myChart" style='width:350px !important;height:350px !important'></canvas>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- ############ PAGE END-->
            </div>
        @endsection

        @push('script')
            <script>
                $(document).ready(function() {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('getdana') }}",
                        success: function(res) {

                            let label = []
                            let datanya = []
                            $.each(res.data, function(key, val) {
                                // console.log(val);
                                label.push(key)
                                datanya.push(val.length)

                            });

                            const ctx = document.getElementById('myChart').getContext('2d');

                            const data = {
                                labels: label,
                                datasets: [{
                                    label: 'My First Dataset',
                                    data: datanya,
                                    backgroundColor: [
                                        'rgb(255, 99, 132)',
                                        'rgb(54, 162, 235)',
                                        'rgba(255, 206, 86)',
                                        'rgba(75, 192, 192)',
                                    ],
                                    hoverOffset: 3,
                                    borderWidth: 1
                                }]
                            };
                            const myChart = new Chart(ctx, {
                                type: 'pie',
                                data: data,
                                options: {
                                    maintainAspectRatio: false,
                                }
                            });
                        }
                    });
                });
            </script>
        @endpush
