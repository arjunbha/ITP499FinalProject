<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/28/14
 * Time: 7:11 PM
 */

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
$session->start();
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

    </style>
    <meta charset="utf-8">
    <title>Stock Login</title>
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
    echo "<div id='flashMessage' style='color:#008000'>$message</div>";
}
?>


<div class="Header">
    <h1>Arjun's Financial Tool Site</h1>
</div>
<div class="navBar"><a href="/stocktool">Stock Tool</a> | <a href="/login">Login</a> | <a href="/admin">Admin</a>
    <div class="line"></div></div>

<h1>Create a new account:</h1>
<form method="post" action="/adminProcess" class="pure-form">
    <h4>Admin Credentials:</h4>
    <div>
        <input type="text" name="username" placeholder="Username">
        &nbsp;&nbsp;&nbsp;&nbsp;
        <input type="password" name="password" placeholder="Password">
    </div>
    <h4>New account information:</h4>
    <div>
        <input type="text" name="newUsername" placeholder="New Username">
    </div>
    <div>
       <input type="password" name="newPassword" placeholder="Password">
    </div>
    <div>
       <input type="password" name="newPasswordRepeat" placeholder="Repeat Password">
    </div>
    <br />
    <div id="submitButton">
        <input type="submit" value="Submit">
    </div>
</form>
</body>
</html>