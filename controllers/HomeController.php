<?php

class HomeController
{
    public function index()
    {
        return Template::render('index');
    }
}