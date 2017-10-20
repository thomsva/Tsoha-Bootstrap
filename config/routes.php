<?php

  $routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
  });

  //Front page

  $routes->get('/', function() {
    WinesController::index();
  });

  //Routes for Wine

  $routes->get('/wine', function() {
    WinesController::index();
  });

  $routes->get('/filter/:tagid', function($tagid) {
    WinesController::filter($tagid);
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

  //$routes->post('/wine/edit/:id', function($id) {
  //  WinesController::retry_edit();
  //});

  $routes->post('/wine/update', function() {
    WinesController::update();
  });

  $routes->get('/wine/delete/:id', function($id) {
    WinesController::destroy($id);
  });

  //Routes for Reviews

  $routes->get('/review/new/:wineid', function($wineid) {
    ReviewsController::create($wineid);
  });

  $routes->post('/review', function() {
    ReviewsController::store();
  });

  $routes->get('/review/edit/:reviewid', function($reviewid) {
    ReviewsController::edit($reviewid);
  });

  $routes->post('/review/update', function() {
    ReviewsController::update();
  });

  $routes->get('/review/delete/:reviewid', function($reviewid) {
    ReviewsController::destroy($reviewid);
  });

  

  //Routes for login and signup

  $routes->get('/signup', function() {
    UsersController::signup();
  });

  $routes->post('/signup', function() {
    UsersController::store();
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

  
