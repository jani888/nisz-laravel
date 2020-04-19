<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Orchestra\Parser\Xml\Facade as Feed;


class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        $news = Cache::remember('news_feed', 1000, function () {
            $feed = Feed::load('https://koronavirus.gov.hu/cikkek/rss.xml')->getContent();
            $news = collect();
            $count = 0;
            foreach ($feed->channel->item as $item) {
                $count++;
                $news->push((object) [
                    'title'       => (string) $item->title,
                    'description' => (string) $item->description,
                    'pubDate'     => (string) $item->pubDate,
                    'link'        => (string) $item->link,
                ]);
                if ($count == 5) break;
            }
            return $news;
        });

        $events = auth()->user()->family->schedule()->with('user')->get();

        $todos = auth()->user()->todos()->orderBy('is_done')->orderBy('created_at', 'DESC')->take(5)->get();


        $covid = Cache::remember('covid_total', 100, function (){
            $client = new Client();
            $data = json_decode($client->get('https://api.covid19api.com/summary')->getBody()->getContents(), false);

            return ['total' => $data->Global, 'hu' => collect($data->Countries)->firstWhere('CountryCode', 'HU')];
        });

        [$chartLabels, $confirmedData, $deadData, $recoveredData] = Cache::remember('covid_chart', 100, function (){
            $client = new Client();
            $data = collect(json_decode($client->get('https://api.covid19api.com/total/country/hungary')->getBody()->getContents(), false));

            return [
                $data->map(function ($row){
                    return Carbon::parse($row->Date)->format('m-d');
                }),
                $data->map(function ($row){
                    return $row->Confirmed;
                }),
                $data->map(function ($row){
                    return $row->Deaths;
                }),
                $data->map(function ($row){
                    return $row->Recovered;
                }),
            ];
        });

        return view('home', compact('news', 'events', 'todos', 'covid', 'chartLabels', 'confirmedData', 'deadData', 'recoveredData'));
    }
}
