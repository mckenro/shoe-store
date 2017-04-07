<?php
  class Store
{
    private $store_name;
    private $id;

    function __construct($store_name, $id=null)
      {
        $this->store_name = $store_name;
        $this->id = $id;
      }

      function getName()
      {
        return $this->store_name;
      }

      function setName($new_store_name)
      {
         $this->store_name = $new_store_name;
      }

      function getId()
      {
        return $this->id;
      }

      function save()
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO stores (store_name) VALUES ('{$this->getName()}'); ");
          if($executed){
            $this->id = $GLOBALS['DB']->lastInsertId();
            return true;
          }else{
          return false;
      }
    }
    static function getAll()
      {
        $stores = array();
        $returned_stores = $GLOBALS['DB']->query('SELECT * FROM stores;');
        foreach($returned_stores as $store)
        {
          $newStore = new Store($store['store_name'], $store["id"]);
          array_push($stores, $newStore);
        }
        return $stores;
      }

      static function deleteAll()
      {
        $deleteAll = $GLOBALS['DB']->exec("DELETE FROM stores;");
        if ($deleteAll)
        {
          return true;
        }else {
          return false;
        }
      }

      function addBrand($brand)
      {
        $executed = $GLOBALS['DB']->exec("INSERT INTO brands_stores (brand_id, store_id) VALUES ({$brand->getId()}, {$this->getId()});");
        if ($executed) {
          return true;
        } else {
          return false;
        }
      }

      function getBrands()
      {
        $query = $GLOBALS['DB']->query("SELECT brand_id FROM brands_stores WHERE store_id = {$this->getId()};");
        $brand_ids = $query->fetchAll(PDO::FETCH_ASSOC);

        $brands = array();
        foreach ($brand_ids as $id) {
          $brand_id = $id['brand_id'];
          $result = $GLOBALS['DB']->query("SELECT * FROM brands WHERE id = {$brand_id};");
          $returned_brand = $result->fetchAll(PDO::FETCH_ASSOC);

          $brand_name = $returned_brand[0]['brand_name'];
          $id = $returned_brand[0]['id'];
          $new_brand = new Brand($brand_name, $id);
          array_push($brands, $new_brand);
        }
        return $brands;
      }

      function delete()
      {
        $executed = $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        if (!$executed) {
          return false;
        }
        $executed = $GLOBALS['DB']->exec("DELETE FROM stores_stores WHERE store_id = {$this->getId()};");
      }
    }

 ?>
