<?php
/**
 * Created by PhpStorm.
 * User: arjunbhargava
 * Date: 4/28/14
 * Time: 5:36 PM
 */

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;

$session = new Session();
$session->clear();
$session->getFlashBag()->add('success','Logged out.');
$response = new RedirectResponse('/login');
$response->send();
?>