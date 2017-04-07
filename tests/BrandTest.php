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
    $newBrand = new Brand ("supershoes");
    $newBrand->save();
    $result = Brand::getAll();
    $this->assertEquals($result, [$newBrand]);
  }

  function test_deleteAll()
  {
    $newBrand = new Brand ("supershoes");
    $newBrand->save();
    Brand::deleteAll();
    $result = Brand::getAll();
    $this->assertEquals($result, []);
  }

  function test_getAll()
  {
    $newBrand = new Brand ('supershoes');
    $newBrand2 = new Brand ('shoemax');
    $newBrand->save();
    $newBrand2->save();
    $result = Brand::getAll();
    $this->assertEquals($result, [$newBrand, $newBrand2] );
  }
}

?>
