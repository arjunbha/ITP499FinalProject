<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/27/14
 * Time: 10:32 PM
 */

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
$session->start();

if(!$session->has('userID')) {
    //This is if they have not logged in already
    $session->getFlashBag()->add('message','Please log in');
    $redirect = new RedirectResponse('/login');
    $redirect->send();
    exit;
}
?>

<!doctype html>
<html>
<head>
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
    <title>List of Stocks</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
</head>
<body>
<?php foreach($session->getFlashBag()->get('message',array()) as $message) {
    echo "<div id='flashMessage' style='color:#A33202'>$message</div>";
}
?>
<?php foreach($session->getFlashBag()->get('success',array()) as $message) {
    echo "<div id='flashMessage' style='color:green'>$message</div>";
}
?>


<div class="Header">
    <h1>Arjun's Financial Tool Site</h1>
</div>
<div class="navBar"><a href="/stocktool">Stock Tool</a> | <a href="/logout">Logout</a> | <a href="/admin">Admin</a>
    <div class="line"></div></div>

<table>
    <tr>
        <td>

        </td>
        <td>
            Company
        </td>
        <td>
            Ticker
        </td>
        <td>
            Price
        </td>
        <td>
            Percentage Change
        </td>
    </tr>

<?php
$YQL = new \ITP\API\YQL();
$userID = $session->get('userID');
$dbStocks = DB::select('SELECT stock_list FROM stocks WHERE user_id = ?', array($userID))[0]->stock_list;
$stockList = $YQL->getPrices($dbStocks);
if(count($stockList) == 0) {

} else if (count($stockList) == 1) {
    $num = 1;
    echo "<td>" . $num . "</td>";

    //Name of company
    $name = @$stockList->Name;
    echo "<td>" . $name . "</td>";

    //Ticker symbol
    $ticker = @$stockList->symbol;
    echo "<td>" . $ticker . "</td>";

    //Price
    $price = @$stockList->LastTradePriceOnly;
    if(substr($price,0,1) == '$') {
        $price = substr($price,1,strlen($price));
    }
    if($price > @$stockList->PreviousClose ) {
        echo "<td style='color:green'>" . $price . "</td>";
    }
    else {
        echo "<td style='color:red'>" . $price . "</td>";
    }

    //Percent Change
    $perChange = @$stockList->ChangeinPercent;
    if($perChange > 0) {
        echo "<td style='color:green'>" . $perChange . "%" . "</td>";
    }
    else {
        echo "<td style='color:red'>" . $perChange . "%" . "</td>";
    }
    echo "</tr>";


} else {
$count = 1;
foreach($stockList as $row) {
echo "<tr>";

    //Number in row
    $num = $count;
    $count++;
    echo "<td>" . $num . "</td>";

    //Name of company
    $name = @$row->Name;
    echo "<td>" . $name . "</td>";

    //Ticker symbol
    $ticker = @$row->symbol;
    echo "<td>" . $ticker . "</td>";

    //Price
    $price = @$row->LastTradePriceOnly;
    if(substr($price,0,1) == '$') {
    $price = substr($price,1,strlen($price));
    }
    if($price > @$row->PreviousClose ) {
        echo "<td style='color:green'>" . $price . "</td>";
    }
    else {
        echo "<td style='color:red'>" . $price . "</td>";
    }

    //Percent Change
    $perChange = @$row->ChangeinPercent;
    if($perChange > 0) {
        echo "<td style='color:green'>" . $perChange . "%" . "</td>";
    }
    else {
        echo "<td style='color:red'>" . $perChange . "%" . "</td>";
    }
    echo "</tr>";
}
}
?>

    </table>
    <form method="get" action="/stockProcess" class="pure-form">
        <div>
            Enter a ticker to add or delete: <input type="text" name="ticker" placeholder="Stock Ticker">
        </div>
        <div id="submitButton">
            <input type="submit" value="Submit">
        </div>
    </form>

</body>
</html>
