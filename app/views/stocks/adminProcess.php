<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/28/14
 * Time: 7:20 PM
 */

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

$request = Request::createFromGlobals();
$session = new Session();
$session->start();

function attempt($username,$password,$newUser,$newPass,$newPassRepeat,$session) {
    $results = DB::select('SELECT * FROM admins WHERE username = ? AND password = ?', array($username, SHA1($password)));
    if(sizeof($results) == 0) {
        $session->getFlashBag()->add('message','Incorrect credentials.');
        $redirect = new RedirectResponse('/admin');
        $redirect->send();
        exit;
    }
    else if(sizeof($results) > 0) {
        //Check to make sure username is unique
        $exists = DB::select('SELECT * FROM users WHERE username = ?', array($newUser));
        if(sizeof($exists)>0) {
            $session->getFlashBag()->add('message','Username already exists.');
            $redirect = new RedirectResponse('/admin');
            $redirect->send();
            exit;
        }

        //Check to make sure passwords match
        elseif($newPass != $newPassRepeat) {
            $session->getFlashBag()->add('message','New passwords do not match.');
            $redirect = new RedirectResponse('/admin');
            $redirect->send();
            exit;
        }

        //Validation for creating a new user
        $validation = Validator::make(
            array(
                'username' => $newUser,
                'password' => $newPass
            ),
            array(
                'username' => 'required|min:3|alpha_num',
                'password' => 'required|min:3'
            )
        );

        if ($validation->passes()) {
            //Insert into users
            DB::insert('insert into users (username,password) values (?,?)',array($newUser,SHA1($newPass)));
            //Insert into stocks a new stock profile (blank stock list) making sure user_id matches
            $user_id = DB::select('SELECT * FROM users WHERE username = ?', array($newUser))[0]->user_id;
            DB::insert('insert into stocks (user_id,stock_list) values (?,?)',array($user_id,""));
            $session->getFlashBag()->add('success','User created.');
            $redirect = new RedirectResponse('/admin');
            $redirect->send();
            exit;

        }
        else {
            //Error with validation
            $session->getFlashBag()->add('message','Username must be alpha_num and > 3 chars. Password must be > 3 chars.');
            $redirect = new RedirectResponse('/admin');
            $redirect->send();
            exit;
        }

    }
}


$username = $request->get('username');
$password = $request->get('password');
$newUser = $request->get('newUsername');
$newPass = $request->get('newPassword');
$newPassRepeat = $request->get('newPasswordRepeat');
attempt($username,$password,$newUser,$newPass,$newPassRepeat,$session);
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
