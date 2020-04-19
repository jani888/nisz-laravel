@extends('layouts.app')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <h3 class="text-primary text-uppercase font-weight-bold">{{auth()->user()->family->name}}</h3>
            </div>
        </div>
        <div class="row d-flex justify-content-center align-items-stretch">
            <div class="col-md-3 col-sm-12">
                <div class="card shadow border-bottom-primary h-100">
                    <div class="card-header">Mai időbeosztás</div>
                    <div class="calendar h-100"></div>
                    <div class="p-2 text-center">
                        <a href="{{config('app.url')}}/schedule">Tovább az időbeosztásra »</a>
                    </div>
                </div>
            </div>
            <div class="col-md-9 col-sm-12">
                <div class="card shadow border-bottom-primary h-100">
                    <div class="card-header">Hírek</div>
                    <div class="card-body">
                        @foreach($news as $article)
                            <div class="card mb-3">
                                <div class="card-header border-0 bg-white p-0 pt-2 pl-3 text-primary">
                                    <h6 class="font-weight-900">{{$article->title}}</h6></div>
                                <div class="card-body text-muted py-0">
                                    <p class="mb-1">{!! substr(strip_tags($article->description), 0, 200)  !!}...</p>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-dark">{{$article->pubDate}}</small>
                                        <a href="{{$article->link}}">
                                            tovább a cikkre »
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        Adatok forrása: <a href="https://koronavirus.gov.hu">www.koronavirus.gov.hu</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 d-flex flex-row justify-content-center align-items-stretch">
            <div class="col h-100">
                <div class="card shadow border-bottom-primary h-100">
                    <div class="card-header">Családtagok</div>
                    @foreach(auth()->user()->family->users as $user)
                        <div class="card mx-2 my-1 p-2">{{$user->name}}</div>
                    @endforeach
                </div>
            </div>
            <div class="col h-100">
                <div class="card shadow border-bottom-primary h-100">
                    <div class="card-header">
                        Teendők
                    </div>
                    <div class="card-body">
                        @foreach($todos as $todo)
                            <div class="card d-flex my-2 px-3 py-1 @if($todo->is_done) bg-light text-muted @endif">
                                <div class="col-12">
                                    <h5>{{$todo->title}}</h5>
                                    <p class="text-muted mb-0">{{substr($todo->description, 0, 100)}}...</p>
                                </div>
                                @if($todo->is_done)
                                    <div class="col-12 d-flex align-items-center ">
                                        <i class="fa fa-check mr-2"></i> Befejezve
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        <div class="p-2 pt-3 text-center">
                            <a href="{{config('app.url')}}/todo">Összes megjelenítése »</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 d-flex flex-row justify-content-center align-items-stretch">
            <div class="col h-100">
                <div class="card shadow border-bottom-primary h-100">
                    <div class="card-header">covid-19 a világon</div>
                    <div class="card-body text-primary font-weight-bolder">
                        <h2>{{number_format($covid['total']->TotalConfirmed, 0, ',', ' ')}}</h2>
                        <span class="badge badge-primary badge-pill">+{{number_format($covid['total']->NewConfirmed, 0, ',', ' ')}}</span>
                        <div class="my-3"></div>
                        <span class="text-success">
                            <i class="fa fa-first-aid"></i> {{number_format($covid['total']->TotalRecovered, 0, ',', ' ')}}
                            <span class="badge badge-success badge-pill">+{{number_format($covid['total']->NewRecovered, 0, ',', ' ')}}</span>
                        </span>
                        <div class="mb-2"></div>
                        <span class="text-dark">
                            <i class="fa fa-dizzy"></i> {{number_format($covid['total']->TotalDeaths, 0, ',', ' ')}}
                            <span class="badge badge-dark badge-pill">+{{number_format($covid['total']->NewDeaths, 0, ',', ' ')}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col h-100">
                <div class="card shadow border-bottom-primary h-100">
                    <div class="card-header">covid-19 Magyarországon</div>
                    <div class="card-body text-primary font-weight-bolder">
                        <h2>{{number_format($covid['hu']->TotalConfirmed, 0, ',', ' ')}}</h2>
                        <span class="badge badge-primary badge-pill">+{{number_format($covid['hu']->NewConfirmed, 0, ',', ' ')}}</span>
                        <div class="my-3"></div>
                        <span class="text-success">
                            <i class="fa fa-first-aid"></i> {{number_format($covid['hu']->TotalRecovered, 0, ',', ' ')}}
                            <span class="badge badge-success badge-pill">+{{number_format($covid['hu']->NewRecovered, 0, ',', ' ')}}</span>
                        </span>
                        <div class="mb-2"></div>
                        <span class="text-dark">
                            <i class="fa fa-dizzy"></i> {{number_format($covid['hu']->TotalDeaths, 0, ',', ' ')}}
                            <span class="badge badge-dark badge-pill">+{{number_format($covid['hu']->NewDeaths, 0, ',', ' ')}}</span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-6 h-100">
                <div class="card shadow border-bottom-primary">
                    <div class="card-header">covid-19 Magyarországon grafikon</div>
                    <div class="p-0 mr-n4">
                        <canvas id="myChart" width="100%" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ' ' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

        // Area Chart Example
        var ctx = document.getElementById("myChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($chartLabels),
                datasets: [
                    {
                        label: "Fertőzöttek",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 115, 223, 1)",
                        pointRadius: 3,
                        pointBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointBorderColor: "rgba(78, 115, 223, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                        pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: @json($confirmedData),
                    },
                    {
                        label: "Gyógyultak",
                        lineTension: 0.3,
                        backgroundColor: "rgba(78, 115, 223, 0.05)",
                        borderColor: "rgba(78, 223, 115, 1)",
                        pointRadius: 2,
                        pointBackgroundColor: "rgba(78, 223, 115, 1)",
                        pointBorderColor: "rgba(78, 223, 115, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(78, 223, 115, 1)",
                        pointHoverBorderColor: "rgba(78, 223, 115, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: @json($recoveredData),
                    },
                    {
                        label: "Halottak",
                        lineTension: 0.3,
                        backgroundColor: "rgba(0, 0, 0, 0.05)",
                        borderColor: "rgba(0, 0, 0, 1)",
                        pointRadius: 2,
                        pointBackgroundColor: "rgba(0, 0, 0, 1)",
                        pointBorderColor: "rgba(0, 0, 0, 1)",
                        pointHoverRadius: 3,
                        pointHoverBackgroundColor: "rgba(0, 0, 0, 1)",
                        pointHoverBorderColor: "rgba(0, 0, 0, 1)",
                        pointHitRadius: 10,
                        pointBorderWidth: 2,
                        data: @json($deadData),
                    }
                ],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            // Include a dollar sign in the ticks
                            callback: function (value, index, values) {
                                return number_format(value);
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                        }
                    }
                }
            }
        });

        var calendar = new FullCalendar.Calendar($('.calendar')[0], {
            plugins: ['timeGrid'],
            defaultView: 'timeGridOneDay',
            header: {
                left: '',
                right: '',
            },
            allDaySlot: false,
            locale: 'hu',
            views: {
                timeGridOneDay: {
                    type: 'timeGrid',
                    duration: {days: 1},
                    buttonText: '1 day'
                }
            },
            height: 'auto',
            slotDuration: '01:00:00',
            nowIndicator: true,
            events: @json($events)
        });

        calendar.render();
    </script>
@endsection
