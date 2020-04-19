<?php

namespace App\Http\Controllers;

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
        $news = Cache::remember('news_feed', 100, function () {
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

        return view('home', compact('news', 'events', 'todos'));
    }
}
