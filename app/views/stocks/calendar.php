<?php
use Symfony\Component\HttpFoundation\Session\Session;

$session = new Session();
$session->start();
?>

<!doctype html>
<html>
<head>
    <title>Calendar Picker</title>
    <style>
        body {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .Header {
            background: url('http://primefinance.in/wp-content/uploads/2013/08/project-finance.jpg');
            height: 100px;
            line-height: 100px;;
        }
        .navBar {
            margin-top: 20px;

        }
        .line {
            border-bottom: 1px solid black;
            width:60%;
            margin-right: auto;
            margin-left: auto;
        }

    </style>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script>
        $(function() {
            $( "#datepicker" ).datepicker();
        });
    </script>
</head>
<body>
<?php foreach($session->getFlashBag()->get('message',array()) as $message) {
    echo "<div id='flashMessage' style='color:#A33202'>$message</div>";
}
?>

<div class="Header">
    <h1>Arjun's Financial Tool Site</h1>
</div>
<div class="navBar"><a href="/stocktool">Stock Tool</a> | <a href="/login">Login</a> | <a href="/admin">Admin</a>
<div class="line"></div></div>

<h3>Pick a date from the calendar below:</h3>
<p>Date must be a past business day (No weekends, no holidays, and not including today)</p>

<form method="get" id="toDate">
<p>Date: <input type="text" id="datepicker"></p>
<input type="submit" vale="Submit" id="submit">
</form>

<script>
    $('#datepicker').bind('change',function() {
        var date = $('#datepicker').val();
        var dArray = date.split("/")
        var year = dArray[2];
        var month = dArray[0];
        var day = dArray[1];
        var string = "/stocktool/".concat(year).concat(month).concat(day);
       $('#toDate').attr("action",string);
    });
</script>


<?php

/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/26/14
 * Time: 3:52 PM
 */


/*$YQL = new \ITP\API\YQL();
$date = 'hello';
$gainers = $YQL->getGainers($date);


foreach($gainers as $row) {
    //Number in row
    $num = $row->td[0]->p;

    //This is to skip the first row
    if($num == 0) {
        continue;
    }

    //Name of company
    $name = $row->td[1]->a->content;
    preg_match('#\((.*?)\)#',$name,$match);

    //Ticker symbol
    $ticker = $match[1];

    //Price
    $price = $row->td[2]->p;

    //Percent Change
    $perChange = $row->td[4]->p;

    //Next day Price
    $nextDayPrice = $YQL->getPrice($date, $ticker);

}




//dd($gainers);*/


?>