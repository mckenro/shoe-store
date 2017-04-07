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
}





 ?>
