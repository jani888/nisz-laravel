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
            <div class="col-3">
                <div class="card h-100">
                    <div class="card-header">Mai időbeosztás</div>
                    <div class="calendar h-100"></div>
                    <div class="p-2 text-center">
                        <a href="{{config('app.url')}}/schedule">Tovább az időbeosztásra »</a>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card h-100">
                    <div class="card-header">Hírek</div>
                    <div class="card-body">
                        @foreach($news as $article)
                            <div class="card mb-3">
                                <div class="card-header border-0 bg-white p-0 pt-2 pl-3 text-primary">
                                    <h6 class="font-weight-900">{{$article->title}}</h6></div>
                                <div class="card-body text-muted py-0">
                                    <p class="mb-1">{!! substr(strip_tags($article->description), 0, 200)  !!}...</p>
                                    <div class="d-flex justify-content-between">
                                        <span>{{$article->pubDate}}</span>
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
                <div class="card h-100">
                    <div class="card-header">Családtagok</div>
                    @foreach(auth()->user()->family->users as $user)
                        <div class="card mx-2 my-1 p-1">{{$user->name}}</div>
                    @endforeach
                </div>
            </div>
            <div class="col h-100">
                <div class="card h-100">
                    <div class="card-header">
                        Teendők
                    </div>
                    <div class="card-body">
                        @foreach($todos as $todo)
                            <div class="card my-2 px-3 py-1">
                                <h5>{{$todo->title}}</h5>
                                <p class="text-muted mb-0">{{substr($todo->description, 0, 100)}}...</p>
                            </div>
                        @endforeach
                        <div class="p-2 pt-3 text-center">
                            <a href="{{config('app.url')}}/todo">Összes megjelenítése »</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
