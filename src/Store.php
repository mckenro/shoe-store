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

    function update($new_name)
    {
          $executed = $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_name}' WHERE id = {$this->getId()};");
          if ($executed) {
              $this->setName($new_name);
              return true;
          } else {
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
        $returned_brands = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN brands_stores ON (stores.id = brands_stores.store_id) JOIN brands ON (brands_stores.brand_id = brands.id) WHERE stores.id = {$this->getId()};");

        $brands = array();
        foreach ($returned_brands as $brand) {
          $brand_name = $brand['brand_name'];
          $id = $brand['id'];
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
        $executed = $GLOBALS['DB']->exec("DELETE FROM brands_stores WHERE store_id = {$this->getId()};");
      }

      static function find($search_id)
      {
        $found_store = null;
        $returned_stores = $GLOBALS['DB']->prepare("SELECT * FROM stores WHERE id = :id");
        $returned_stores->bindParam(':id', $search_id, PDO::PARAM_STR);
        $returned_stores->execute();
        foreach($returned_stores as $store) {
          $store_name = $store['store_name'];
          $id = $store['id'];
          if ($id == $search_id) {
            $found_store = new Store($store_name, $id);
          }
        }
        return $found_store;
      }
    }

 ?>
