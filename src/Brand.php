<?php
  class Brand
{
    private $brand_name;
    private $id;

    function __construct($brand_name, $id=null)
      {
        $this->brand_name = $brand_name;
        $this->id = $id;
      }

      function getName()
      {
        return $this->brand_name;
      }

      function setName($new_name)
      {
         $this->brand_name = $new_name;
      }

      function getId()
      {
        return $this->id;
      }

      function save()
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getName()}'); ");
          if($executed){
            $this->id = $GLOBALS['DB']->lastInsertId();
            return true;
          }else{
          return false;
          }
      }

      static function getAll()
      {
        $brands = array();
        $returned_brands = $GLOBALS['DB']->query('SELECT * FROM brands;');
        foreach($returned_brands as $brand){
          $newBrand = new Brand($brand['brand_name'], $brand["id"]);
          array_push($brands, $newBrand);
        }
          return $brands;
      }

      static function deleteAll()
      {
        $deleteAll = $GLOBALS['DB']->exec("DELETE FROM brands;");
        if ($deleteAll)
        {
          return true;
        }else {
          return false;
        }
      }

      function addStore($store)
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$this->getId()}, {$store->getId()});");
        if ($executed) {
          return true;
        } else {
          return false;
        }
      }

      function getStores()
      {
        $query = $GLOBALS['DB']->query("SELECT store_id FROM brands_stores WHERE brand_id = {$this->getId()};");
        $store_ids = $query->fetchAll(PDO::FETCH_ASSOC);

        $stores = array();
        foreach ($store_ids as $id) {
          $store_id = $id['store_id'];
          $result = $GLOBALS['DB']->query("SELECT * FROM stores WHERE id = {$store_id};");
          $returned_store = $result->fetchAll(PDO::FETCH_ASSOC);

          $store_name = $returned_store[0]['store_name'];
          $id = $returned_store[0]['id'];
          $new_store = new Store($store_name, $id);
          array_push($stores, $new_store);
        }
        return $stores;
      }

      function delete()
      {
        $executed = $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        if (!$executed) {
          return false;
        }
        $executed = $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE brand_id = {$this->getId()};");
      }
}

 ?>
