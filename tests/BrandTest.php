<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

$DB = new PDO('mysql:host=localhost:8889;dbname=shoes_test', "root", "root");
require_once "src/Store.php";
require_once "src/Brand.php";

class BrandTest extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    Brand::deleteAll();
    Store::deleteAll();
  }

  function test_save()
  {
    $newBrand = new Brand ("Super Shoes");
    $newBrand->save();
    $result = Brand::getAll();
    $this->assertEquals([$newBrand], $result);
  }

  function test_deleteAll()
  {
    $newBrand = new Brand ("Super Shoes");
    $newBrand->save();
    Brand::deleteAll();
    $result = Brand::getAll();
    $this->assertEquals($result, []);
  }

  function test_getAll()
  {
    $newBrand = new Brand ('Super Shoes');
    $newBrand2 = new Brand ('Shoe Max');
    $newBrand->save();
    $newBrand2->save();
    $result = Brand::getAll();
    $this->assertEquals($result, [$newBrand, $newBrand2] );
  }

  function test_addStore()
  {
    $brand_name = "Super Shoes";
    $test_brand = new Brand($brand_name);
    $test_brand->save();

    $store_name = "Wal Mart";
    $test_store = new Store($store_name);
    $test_store->save();

    $test_brand->addStore($test_store);

    $this->assertEquals($test_brand->getStores(), [$test_store]);
  }

  function test_getStores()
  {
    $brand_name = "Super Shoes";
    $test_brand = new Brand($brand_name);
    $test_brand->save();

    $store_name = "Wal Mart";
    $test_store = new Store($store_name);
    $test_store->save();

    $store_name2 = "Nordstrom";
    $test_store2 = new Store($store_name);
    $test_store2->save();

    $test_brand->addStore($test_store);
    $test_brand->addStore($test_store2);

    $this->assertEquals($test_brand->getStores(), [$test_store, $test_store2]);
  }

  function test_delete()
  {
    $brand_name = "Super Shoes";
    $test_brand = new Brand($brand_name);
    $test_brand->save();

    $store_name = "Wal Mart";
    $test_store = new Store($store_name);
    $test_store->save();

    $test_brand->addStore($test_store);
    $test_brand->delete();

    $this->assertEquals([], $test_store->getBrands());
  }
}

?>
