<?php

use \AjudaNerd\PageAdmin;
use \AjudaNerd\Model\User;

$app->get('/admin', function() {

    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("/index");

});

$app->get('/admin/login', function() {

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("login");

});

$app->post('/admin/login', function() {

    User::login($_POST["login"], $_POST["password"]);

    header("Location: /AjudaNerd2.0/admin");

    exit;

});

?>