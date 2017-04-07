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

  function test_deleteAll()
  {
    $newStore = new Store ("superstore");
    $newStore->save();
    Store::deleteAll();
    $result = Store::getAll();
    $this->assertEquals([], $result);
  }

  function test_getAll()
  {
    $newStore = new Store ("superstore");
    $newStore2 = new Store ("max-mart");
    $newStore->save();
    $newStore2->save();
    $result = Store::getAll();
    $this->assertEquals([$newStore, $newStore2], $result);
  }
}

?>
