<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/27/14
 * Time: 8:45 PM
 */

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

$request = Request::createFromGlobals();
$session = new Session();
$session->start();

function attempt($username, $password, $session) {
    $results = DB::select('SELECT * FROM users WHERE username = ? AND password = ?', array($username, SHA1($password)));
    if(sizeof($results) == 0) {
        $session->getFlashBag()->add('message','Incorrect credentials.');
        $redirect = new RedirectResponse('/login');
        $redirect->send();
    }
    else if(sizeof($results) > 0) {
        $userID = $results[0]->user_id;
        $stocks = DB::select('SELECT * FROM stocks WHERE user_id = ?', array($userID));
        //$session->set('stockList', $stocks[0]->stock_list);
        $session->set('userID', $stocks[0]->user_id);
        $session->getFlashBag()->add('success','Logged in successfully.');
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
}


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
