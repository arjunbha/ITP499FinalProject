<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/28/14
 * Time: 11:30 AM
 */

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

$request = Request::createFromGlobals();
$session = new Session();
$session->start();

$requestStock = $request->get('ticker');


    //first check if its in list and delete
    $userID = $session->get('userID');
    $dbStocks = DB::select('SELECT stock_list FROM stocks WHERE user_id = ?', array($userID))[0]->stock_list;
    $arrayOfStocks = explode(",",$dbStocks);
    if(($key = array_search($requestStock, $arrayOfStocks)) !== false) {
        unset($arrayOfStocks[$key]);
        $stringOfStocks = implode(",",$arrayOfStocks);
        DB::update('update stocks set stock_list = ? where user_id = ?', array($stringOfStocks,$session->get('userID')));
        $session->getFlashBag()->add('success','Portfolio updated');
        $redirect = new RedirectResponse('/stocks');
        $redirect->send();
        exit;
    }

    //then validate stock
    $YQL = new \ITP\API\YQL();
    $stockList = $YQL->getPrices($dbStocks);
    if($YQL->validateStock($requestStock)) {
        //add and update db and session
        $stringOfStocks = $dbStocks;
        $stringOfStocks .= "," . $requestStock;
        DB::update('update stocks set stock_list = ? where user_id = ?', array($stringOfStocks,$session->get('userID')));
        $session->getFlashBag()->add('success','Successfully added');
        $redirect = new RedirectResponse('/stocks');
        $redirect->send();
    } else {
        //return with error
        $session->getFlashBag()->add('message','Invalid Stock Ticker (here are some example tickers: GOOG, AAPL, MSFT, NFLX, AMZN, TWTR');
        $redirect = new RedirectResponse('/stocks');
        $redirect->send();
    }





    /*$sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $statement = $this->pdo->prepare($sql);
    $encrypted = SHA1($password);
    $statement->bindParam(1, $username);
    $statement->bindParam(2, $encrypted);
    $statement->execute();
    $authResponse = $statement->fetchAll();

    if(sizeof($authResponse) == 1) {
        $session = new Session();
        $session->set('email',$authResponse[0]["email"]);
        return true;
    }
    else {
        return false;
    }*/


$username = $request->get('username');
$password = $request->get('password');
attempt($username,$password,$session);
/*$auth = new Auth($pdo);
if($auth->attempt($username,$password)) {
    $session->set('username', $username);
    $session->set('timestamp', Carbon::now());
    $session->getFlashBag()->add('login','You have successfully logged in!');
    $redirect = new RedirectResponse('dashboard.php');
    $redirect->send();
}
else {
    $session->getFlashBag()->add('message','Incorrect credentials');
    $redirect = new RedirectResponse('login.php');
    $redirect->send();
}*/
