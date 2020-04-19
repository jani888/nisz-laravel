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
                <h3 class="text-primary text-uppercase font-weight-bold">{{auth()->user()->family->name}} család</h3>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card shadow border-bottom-primary">
                    <div class="card-header">Family finder</div>

                    @if($family->longitude != null)
                        <div class="card-body d-flex">
                            <div class="col">
                                @foreach($families as $family)
                                    <form action="{{config('app.url')}}/family-finder/{{$family->id}}" method="post">
                                        <div class="card p-2 my-2 d-flex flex-row justify-content-between align-items-center">
                                            <span>{{$family->name}} | <span class="text-muted">{{number_format($family->distance, 2, '.', ' ')}} km</span></span>

                                            <button class="btn btn-outline-primary btn-sm">Kapcsolat felvétele</button>
                                        </div>
                                    </form>
                                @endforeach
                            </div>
                            <div id="mapdiv" class="col" style="height: 500px"></div>
                        </div>
                    @else
                        <div class="card-body text-center">
                            <p>Nincs megosztva a helyzeted. A családok kereséséhez engedélyezd a helyzetmegosztást.</p>

                            <button class="btn btn-primary findMe">Helyzet megosztása</button>
                        </div>

                        <form action="{{config('app.url')}}/family-finder/setlocation" id="setlocation-form" method="post">
                            @csrf
                            <input type="hidden" name="longitude" id="longitude-input">
                            <input type="hidden" name="latitude" id="latitude-input">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        const latitude = '{{$family->latitude}}';
        const longitude = '{{$family->longitude}}';
        const friends = @json($friends ?? [])

        map = new OpenLayers.Map("mapdiv");
        map.addLayer(new OpenLayers.Layer.OSM());

        var lonLat = new OpenLayers.LonLat(longitude, latitude)
            .transform(
                new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                map.getProjectionObject() // to Spherical Mercator Projection
            );

        var zoom = 12;

        var markers = new OpenLayers.Layer.Markers("Markers");
        markers.addMarker(new OpenLayers.Marker(lonLat));
        friends.forEach(family => {
            console.log(family);
            var lonLat = new OpenLayers.LonLat(family.longitude, family.latitude)
                .transform(
                    new OpenLayers.Projection("EPSG:4326"), // transform from WGS 1984
                    map.getProjectionObject() // to Spherical Mercator Projection
                );
            markers.addMarker(new OpenLayers.Marker(lonLat));
        })
        map.addLayer(markers);


        map.setCenter(lonLat, zoom);

        function geoFindMe() {
            function success(position) {
                $("#longitude-input").val(position.coords.longitude)
                $("#latitude-input").val(position.coords.latitude)
                $("#setlocation-form").submit();
            }

            function error() {
            }

            if (!navigator.geolocation) {
            } else {
                navigator.geolocation.getCurrentPosition(success, error);
            }
        }

        $('.findMe').click(function () {
            geoFindMe();
        })
    </script>
@endsection
