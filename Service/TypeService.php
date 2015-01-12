<?php
namespace Striide\InventoryBundle\Service;

class TypeService
{
  private $doctrine = null;
  public function __construct($doctrine)
  {
    $this->doctrine = $doctrine;

  }
  public function getInventoryTypesArray()
  {
    $base_types = array('Furniture', 'Materials', 'Equipment', 'Appliances');

    $sql = " SELECT distinct(type) FROM striide_inventory_item";

    $stmt = $this->doctrine->getManager()->getConnection()->prepare($sql);
    $stmt->execute();
    $all = $stmt->fetchAll();

    foreach($all as $item)
    {
      $base_types[] = $item['type'];
    }

    $types = array_unique($base_types);

    return $types;
  }
}
