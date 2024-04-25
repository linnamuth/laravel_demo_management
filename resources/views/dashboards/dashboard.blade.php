@extends('layouts.master')

@section('content')
    <div class="container">

        <div class="row g-6 mb-6">
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">Users</span>
                                @if ($users->count() > 0)
                                    <span class="h3 font-bold mb-0">{{ $users->count() ?: 0 }}</span>
                                @endif
                                <a href="{{ route('users.index') }}"></a>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-tertiary text-white text-lg rounded-circle">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">Leaves</span>
                                <span class="h3 font-bold mb-0">{{ $requestLeaves->count() ?: 0 }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-primary text-white text-lg rounded-circle">
                                    <i class="bi bi-calendar-plus"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 col-12">
                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="h6 font-semibold text-muted text-sm d-block mb-2">Missions</span>
                                <span class="h3 font-bold mb-0">{{ $missionLeaves->count() ?: 0 }}</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-info text-white text-lg rounded-circle">
                                    <i class="bi bi-calendar-plus"></i>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card shadow border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <span class="h6 font-semibold text-muted text-sm d-block mb-2">Departments</span>
                                    <span
                                        class="h3 font-bold mb-0">{{$departments->count() ? :0 }}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white text-lg rounded-circle">
                                        <i class="bi bi bi-building"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div>

            <div class="row my-2">
                <div class="col-md-6 py-1">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="chLine"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 py-1">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="chBar"></canvas>
                        </div>
                    </div>
                </div>
            </div>
                <div class="card">
                <table class="table ">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Department</th>
                    </tr>
                    @foreach ($users as $key => $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-secondary text-dark">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $user->department ? $user->department->name : '' }}</td>


                        </tr>
                    @endforeach
                </table>
                </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        var colors = ['#007bff', '#28a745', '#333333', '#c3e6cb', '#dc3545', '#6c757d'];

        var chLine = document.getElementById("chLine");
        var chartData = {
            labels: ["S", "M", "T", "W", "T", "F", "S"],
            datasets: [{
                    data: [589, 445, 483, 503, 689, 692, 634],
                    backgroundColor: 'transparent',
                    borderColor: colors[0],
                    borderWidth: 4,
                    pointBackgroundColor: colors[0]
                }


            ]
        };
        if (chLine) {
            new Chart(chLine, {
                type: 'line',
                data: chartData,
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                beginAtZero: false
                            }
                        }]
                    },
                    legend: {
                        display: false
                    },
                    responsive: true
                }
            });
        }

        /* large pie/donut chart */
        var chPie = document.getElementById("chPie");
        if (chPie) {
            new Chart(chPie, {
                type: 'pie',
                data: {
                    labels: ['Desktop', 'Phone', 'Tablet', 'Unknown'],
                    datasets: [{
                        backgroundColor: [colors[1], colors[0], colors[2], colors[5]],
                        borderWidth: 0,
                        data: [50, 40, 15, 5]
                    }]
                },
                plugins: [{
                    beforeDraw: function(chart) {
                        var width = chart.chart.width,
                            height = chart.chart.height,
                            ctx = chart.chart.ctx;
                        ctx.restore();
                        var fontSize = (height / 70).toFixed(2);
                        ctx.font = fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        var text = chart.config.data.datasets[0].data[0] + "%",
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                }],
                options: {
                    layout: {
                        padding: 0
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80
                }
            });
        }

        /* bar chart */
        var chBar = document.getElementById("chBar");
        if (chBar) {
            new Chart(chBar, {
                type: 'bar',
                data: {
                    labels: ["S", "M", "T", "W", "T", "F", "S"],
                    datasets: [{
                            data: [589, 445, 483, 503, 689, 692, 634],
                            backgroundColor: colors[0]
                        },
                        {
                            data: [639, 465, 493, 478, 589, 632, 674],
                            backgroundColor: colors[1]
                        }
                    ]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            barPercentage: 0.4,
                            categoryPercentage: 0.5
                        }]
                    }
                }
            });
        }

        /* 3 donut charts */
        var donutOptions = {
            cutoutPercentage: 85,
            legend: {
                position: 'bottom',
                padding: 5,
                labels: {
                    pointStyle: 'circle',
                    usePointStyle: true
                }
            }
        };
    </script>
@endsection
