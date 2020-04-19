@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card shadow border-bottom-primary">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Időbeosztás</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form action="{{route('schedule')}}" method="post">
                    <div class="modal-body">
                        <h4>Számítógéphasználat hozzáadása</h4>
                        <div>
                            <span id="from-date"></span>
                            -
                            <span id="to-date"></span>
                        </div>

                        @csrf
                        <input type="hidden" name="from" id="input-from">
                        <input type="hidden" name="to" id="input-to">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégsem</button>
                        <button type="submit" class="btn btn-primary">Hozzáadás</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Számítógéphasználat</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <form action="{{route('schedule')}}/" id="delete-form" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        Létrehozva: <span id="created_at"></span>
                        <br>
                        Felhasználó: <span id="user"></span>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Mégsem</button>
                        <button type="submit" class="btn btn-danger delete-btn">Törlés</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let dateFormat = function (date) {
            return date.getFullYear() + '.' + (date.getMonth()+1) + '.' + date.getDate() + '. ' + (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':' + (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes());
        };

        let authUser = @json(auth()->user())

        var currentStart, currentEnd;

        var calendar = new FullCalendar.Calendar($('#calendar')[0], {
            plugins: ['timeGrid', 'interaction'],
            locale: 'hu',
            nowIndicator: true,
            allDaySlot: false,
            selectable: true,
            defaultView: 'timeGridWeek',
            events: @json($events),
            eventClick: function ({event}){
                console.log(event);
                $("#editModal").modal('show');
                $("#created_at").text(event.extendedProps.created_at);
                $("#user").text(event.extendedProps.user.name);
                if(event.extendedProps.user.id == authUser.id){
                    $('.delete-btn').show();
                    $('#delete-form').attr('action', $('#delete-form').attr('action') + event.id);
                }else{
                    $('.delete-btn').hide();
                }
            },
            select: function ({start, end}) {
                currentStart = start;
                currentEnd = end;
                $("#modal").modal('show');
                $("#from-date").text(dateFormat(start))
                $("#input-from").val(dateFormat(start))
                $("#to-date").text(dateFormat(end))
                $("#input-to").val(dateFormat(end))
            }
        });
        calendar.render();
    </script>
@endsection