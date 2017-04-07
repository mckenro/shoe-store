<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

$DB = new PDO('mysql:host=localhost:8889;dbname=shoes_test', "root", "root");
require_once "src/Store.php";
require_once "src/Brand.php";

class StoreTest extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    Store::deleteAll();
    Brand::deleteAll();
  }

  function test_save()
  {
    $newStore = new Store ("superstore");
    $newStore->save();
    $result = Store::getAll();
    $this->assertEquals([$newStore], $result);
  }

  function test_update()
  {
    $store_name = "Super Store";
    $test_store = new Store($store_name);
    $test_store->save();
    $new_store = "Nordstrom";

    $test_store->update($new_store);

    $this->assertEquals("Nordstrom", $test_store->getName());
  }

  function test_deleteAll()
  {
    $newStore = new Store ("Super Store");
    $newStore->save();
    Store::deleteAll();
    $result = Store::getAll();
    $this->assertEquals([], $result);
  }

  function test_getAll()
  {
    $newStore = new Store ("Super Store");
    $newStore2 = new Store ("Wal Mart");
    $newStore->save();
    $newStore2->save();
    $result = Store::getAll();
    $this->assertEquals([$newStore, $newStore2], $result);
  }

  function test_addBrand()
  {
    $store_name = "Wal Mart";
    $test_store = new Store($store_name);
    $test_store->save();

    $brand_name = "Super Shoes";
    $test_brand = new Brand($brand_name);
    $test_brand->save();

    $test_store->addBrand($test_brand);

    $this->assertEquals($test_store->getBrands(), [$test_brand]);
  }

  function test_getBrands()
  {
    $store_name = "Wal Mart";
    $test_store = new Store($store_name);
    $test_store->save();

    $brand_name = "Super Shoes";
    $test_brand = new Brand($brand_name);
    $test_brand->save();

    $brand_name2 = "Nike";
    $test_brand2 = new Brand($brand_name);
    $test_brand2->save();

    $test_store->addBrand($test_brand);
    $test_store->addBrand($test_brand2);

    $this->assertEquals($test_store->getBrands(), [$test_brand, $test_brand2]);
  }

  function test_delete()
  {
    $store_name = "Wal Mart";
    $test_store = new Store($store_name);
    $test_store->save();

    $brand_name = "Super Shoes";
    $test_brand = new Brand($brand_name);
    $test_brand->save();

    $test_store->addBrand($test_brand);
    $test_store->delete();

    $this->assertEquals([], $test_brand->getStores());
  }
}

?>
