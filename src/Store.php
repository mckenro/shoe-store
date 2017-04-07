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
    }

 ?>
