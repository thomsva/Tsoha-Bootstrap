<?php

  $routes->get('/', function() {
    HelloWorldController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/winelist', function() {
    HelloWorldController::winelist();
  });

  $routes->get('/wineshow', function() {
    HelloWorldController::wineshow();
  });

  $routes->get('/winereview', function() {
    HelloWorldController::winereview();
  });

  $routes->get('/signup', function() {
    HelloWorldController::signup();
  });

  $routes->get('/login', function() {
    HelloWorldController::login();
  });


  
