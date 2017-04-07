<?php
  date_default_timezone_set('America/Los_Angeles');
  require_once __DIR__."/../vendor/autoload.php";
  require_once __DIR__."/../src/Brand.php";
  require_once __DIR__.'/../src/Store.php';

  use Symfony\Component\Debug\Debug;
  Debug::enable();

  $app = new Silex\Application();
  $DB = new PDO('mysql:host=localhost:8889;dbname=shoes', 'root', 'root');
  $app['debug'] = true;
  $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
  ));

  use Symfony\Component\HttpFoundation\Request;
  Request::enableHttpMethodParameterOverride();

  $app->get("/", function() use ($app) {
    return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
  });

  $app->post("/stores", function() use ($app) {
    $store = new Store($_POST['store']);
    $store->save();
    return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
  });

  $app->post("/brands", function() use ($app) {
    $brand = new Brand($_POST['brand']);
    $brand->save();
    return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
  });

  $app->post("/delete_stores", function() use ($app) {
    Store::deleteAll();
    return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
  });

  $app->post("/delete_brands", function() use ($app) {
    Brand::deleteAll();
    return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
  });

  // ---------------------------------------
  // store update and delete below this line

  $app->get("/store_edit/{id}", function($id) use ($app) {
    $current_store = Store::find($id);
    $store_brands = $current_store->getBrands();
    return $app['twig']->render('store_edit.html.twig', array('stores' => $current_store, 'brands' => $store_brands));
  });

  $app->patch("/store_edit/{id}", function($id) use ($app) {
    $current_store = Store::find($id);
    $new_name = $_POST['store_edit'];
    $current_store->update($new_name);
    $store_brands = $current_store->getBrands();
    return $app['twig']->render('store_edit.html.twig', array('stores' => $current_store, 'brands' => $store_brands));
  });

  $app->delete("/store_edit/{id}", function($id) use ($app) {
    $current_store = Store::find($id);
    $current_store->delete();
    return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
  });

  // ---------------------------------------
  // brand update and delete below this line

  $app->get("/brand_edit/{id}", function($id) use ($app) {
    $current_brand = Brand::find($id);
    $brand_stores = $current_brand->getStores();
    return $app['twig']->render('brand_edit.html.twig', array('brands' => $current_brand, 'stores' => $brand_stores));
  });

  $app->patch("/brand_edit/{id}", function($id) use ($app) {
    $current_brand = Brand::find($id);
    $new_name = $_POST['brand_edit'];
    $current_brand->update($new_name);
    $brand_stores = $current_brand->getStores();
    return $app['twig']->render('brand_edit.html.twig', array('brands' => $current_brand, 'stores' => $brand_stores));
  });

  $app->delete("/brand_edit/{id}", function($id) use ($app) {
    $current_brand = Brand::find($id);
    $current_brand->delete();
    return $app['twig']->render('index.html.twig', array('stores' => Store::getAll(), 'brands' => Brand::getAll()));
  });

  // ---------------------------------------
  // add store(s) to brand below this line

  $app->post("/brand_edit/{id}", function($id) use ($app) {
    $current_brand = Brand::find($id);
    $new_store = $_POST['add_store'];
    $current_brand->addStore($new_store);
    return $app['twig']->render('brand_edit.html.twig', array('brands' => $current_brand, 'stores' => $brand_stores));
  });


  return $app;
 ?>
