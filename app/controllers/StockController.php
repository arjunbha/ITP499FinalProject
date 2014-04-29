<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/26/14
 * Time: 3:56 PM
 */

class StockController extends BaseController {

    public function showCalendar() {
        return View::make('stocks/calendar');
    }

    public function showGainers($date) {
        return View::make('stocks/gainers', [
            'date' => $date
        ]);
    }

    public function login() {
        return View::make('stocks/login');
    }

    public function loginProcess() {
        return View::make('stocks/loginProcess');
    }

    public function showStocks() {
        return View::make('stocks/showStocks');
    }

    public function stockProcess() {
        return View::make('stocks/stockProcess');
    }

    public function logout() {
        return View::make('stocks/logout');
    }

    public function admin() {
        return View::make('stocks/admin');
    }

    public function adminProcess() {
        return View::make('stocks/adminProcess');
    }


    /*public function listSongs() {
        $song_title = Input::get('song_title'); // $_GET
        $artist = Input::get('artist');

        $songs = Song::search($song_title,$artist);

        //dd($songs);
        return View::make('songs/songs-list', [
            'songs' => $songs
        ]);
    }*/


}