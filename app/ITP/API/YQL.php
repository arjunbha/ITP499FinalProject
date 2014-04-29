<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/26/14
 * Time: 4:14 PM
 */

namespace ITP\API;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

class YQL {

    function curl($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    public function getGainers($date) {
        $session = new Session();
        $session->start();
        $endpoint = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20html%20where%20url%3D'http%3A%2F%2Fonline.wsj.com%2Fmdc%2Fpublic%2Fpage%2F2_3021-gainnyse-gainer-" . $date . ".html%3Fmod%3Dmdc_pastcalendar'%20and%20xpath%3D'%2F%2Fdiv%5B%40class%3D%22mdcNarrowM%22%5D%2Ftable%2Ftr'&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
        $json = $this->curl($endpoint);
        $decoded = json_decode($json,false);
        if($decoded->query->results == null) {
            //$session->getFlashBag()->add('message','Please log in');
            $session->getFlashBag()->add('message','Incorrect date. Must be past business day(M-F) excluding today and holidays.');
            $redirect = new RedirectResponse('/stocktool');
            $redirect->send();
        } else {
            return $decoded->query->results->tr;
        }
    }

    public function getPrice($date,$ticker) {
        $endpoint = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.historicaldata%20where%20symbol%20%3D%20%22" . $ticker ."%22%20and%20startDate%20%3D%20%22" . $date . "%22%20and%20endDate%20%3D%20%22" . $date . "%22&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
        $json = $this->curl($endpoint);
        $decoded = json_decode($json,false);
        if(@$decoded->query->results != null) {
            return @$decoded->query->results->quote->Close;
        }
        else {
            return "N/A";
        }
    }

    public function getPrices($stocks) {
        $stocksSorted = explode(",",$stocks);
        $endpoint = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quotes%20where%20symbol%20in%20(";
        foreach($stocksSorted as $stock) {
            $endpoint .= "%22" . $stock . "%22" . "%2C";
        }
        $endpoint = substr($endpoint, 0, -3);
        $endpoint .= ")&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
        $json = $this->curl($endpoint);
        $decoded = json_decode($json,false);
        return @$decoded->query->results->quote;
    }

    public function validateStock($stock) {
        $endpoint = "https://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.quote%20where%20symbol%20in%20(%22" . $stock ."%22)&format=json&diagnostics=true&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys&callback=";
        $json = $this->curl($endpoint);
        $decoded = json_decode($json,false);
        if($decoded->query->results->quote->StockExchange == null) {
            return false;
        }
        else {
            return true;
        }
    }

} 