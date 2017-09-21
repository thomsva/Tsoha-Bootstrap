<?php

  $routes->get('/', function() {
    WinesController::index();
  });

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  $routes->get('/wine', function() {
    WinesController::index();
  });

  $routes->post('/wine', function() {
    WinesController::store();
  });

  $routes->get('/wine/new', function() {
    WinesController::create();
  });

  $routes->get('/wine/:id', function($id) {
    WinesController::wineshow($id);
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


  
