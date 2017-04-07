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

      function update($new_name)
      {
            $executed = $GLOBALS['DB']->exec("UPDATE brands SET brand_name = '{$new_name}' WHERE id = {$this->getId()};");
            if ($executed) {
                $this->setName($new_name);
                return true;
            } else {
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
        $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands JOIN brands_stores ON (brands.id = brands_stores.brand_id) JOIN stores ON (brands_stores.store_id = stores.id) WHERE brands.id = {$this->getId()};");

        $stores = array();
        foreach ($returned_stores as $store) {
          $store_name = $store['store_name'];
          $id = $store['id'];
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

      static function find($search_id)
      {
        $found_brand = null;
        $returned_brands = $GLOBALS['DB']->prepare("SELECT * FROM brands WHERE id = :id");
        $returned_brands->bindParam(':id', $search_id, PDO::PARAM_STR);
        $returned_brands->execute();
        foreach($returned_brands as $brand) {
          $brand_name = $brand['brand_name'];
          $id = $brand['id'];
          if ($id == $search_id) {
            $found_brand = new Brand($brand_name, $id);
          }
        }
        return $found_brand;
      }
}

 ?>
