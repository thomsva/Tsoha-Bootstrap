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

  $routes->get('/wine/edit/:id', function($id) {
    WinesController::edit($id);
  });

  $routes->post('/wine/edit/:id', function($id) {
    WinesController::retry_edit();
  });

  $routes->post('/wine/update', function() {
    WinesController::update();
  });

  $routes->get('/wine/delete/:id', function($id) {
    WinesController::destroy($id);
  });

  $routes->get('/winereview', function() {
    HelloWorldController::winereview();
  });

  $routes->get('/signup', function() {
    HelloWorldController::signup();
  });

  $routes->get('/login', function(){
    UsersController::login();
  });

  $routes->post('/login', function(){
    UsersController::handle_login();
  });

  $routes->get('/logout', function(){
    UsersController::logout();
  });

  
