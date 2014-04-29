<!doctype html>
<html>
<head>
    <title>Gainers for <?php echo $date; ?></title>
    <style>
        body {
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }
        .Header {
            background: url('http://primefinance.in/wp-content/uploads/2013/08/project-finance.jpg');
            height: 100px;
            line-height: 100px;
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
        table {
            margin-left: auto;
            margin-right: auto;

        }
        td {
            padding: 10px;
            border: 1px solid black;
        }
    </style>
    <meta charset="utf-8">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">

</head>
<body>

<div class="Header">
    <h1>Arjun's Financial Tool Site</h1>
</div>
<div class="navBar"><a href="/stocktool">Stock Tool</a> | <a href="/login">Login</a> | <a href="/admin">Admin</a>
    <div class="line"></div></div>

<table>
    <tr>
        <td>

        </td>
        <td>
            Company
        </td>
        <td>
            Price
        </td>
        <td>
            Percentage Change
        </td>
        <td>
            Next Day Price
        </td>
        <td>
            Next Day Percentage Change
        </td>
    </tr>

<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/26/14
 * Time: 11:25 PM
 */


$YQL = new \ITP\API\YQL();
$gainers = $YQL->getGainers($date);

foreach($gainers as $row) {
    echo "<tr>";

    //Number in row
    $num = $row->td[0]->p;

    //This is to skip the first row
    if($num == 0) {
        continue;
    }
    echo "<td>" . $num . "</td>";

    //Name of company
    $name = $row->td[1]->a->content;
    preg_match('#\((.*?)\)#',$name,$match);
    echo "<td>" . $name . "</td>";

    //Ticker symbol
    $ticker = $match[1];

    //Price
    $price = $row->td[2]->p;
    if(substr($price,0,1) == '$') {
        $price = substr($price,1,strlen($price));
    }
    echo "<td style='color:green'>" . $price . "</td>";

    //Percent Change
    $perChange = $row->td[4]->p;
    echo "<td style='color:green'>" . $perChange . "%" . "</td>";

    //Next day Price
    $modifiedDate = substr($date,0,4)."-".substr($date,4,2)."-".substr($date,6,2);
    $nextDayDate = date('Y-m-d', strtotime($date .' +1 Weekday'));
    $nextDayPrice = $YQL->getPrice($nextDayDate, $ticker);

    //Next day Percent Change;
    //$nextDayPerChange;
    //if($nextDayPrice == "N/A") {
    //    $nextDayPerChange = "N/A";
    //} else {
        $nextDayPerChange = @round(((floatval($nextDayPrice)-floatval($price))/floatval($price))*100,3);
        if($nextDayPerChange > 0 ) {
            echo "<td style='color:green'>" . $nextDayPrice . "</td>";
            echo "<td style='color:green'>" . $nextDayPerChange . "%" . "</td>";
        }
        else {
            echo "<td style='color:red'>" . $nextDayPrice . "</td>";
            echo "<td style='color:red'>" . $nextDayPerChange ."%" . "</td>";
        }
    //}

    echo "</tr>";
}