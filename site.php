<?php

use \AjudaNerd\Page;

$app->get('/', function () {

    $page = new Page();

    $page->setTpl("index");

});