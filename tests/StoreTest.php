<?php
/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

$DB = new PDO('mysql:host=localhost:8889;dbname=shoe_store_test', "root", "root");
require_once "src/Store.php";
require_once "src/Brand.php";
class StoreTest extends PHPUnit_Framework_TestCase
{
  protected function tearDown()
  {
    Store::deleteAll();
    Brand::deleteAll();

  }
    function test_Save()
    {
      $newClass = new Store ("max", "blue");
      $newClass->save();
      $result = Store::getAll();
      $this->assertEquals($result, [$newClass]);
    }

    function test_deleteAll()
    {
      $newClass = new Store ("max","blue");
      $newClass->save();
      Store::deleteAll();
      $result = Store::getAll();
      $this->assertEquals($result, []);
    }
    function test_getAll()
    {
      $newClass = new Store ('max', 'blue');
      $newClass2 = new Store ('jack', "black");
      $newClass->save();
      $newClass2->save();
      $result = Store::getAll();
      $this->assertEquals($result, [$newClass, $newClass2] );
    }
  }






?>
