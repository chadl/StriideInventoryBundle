<?php
namespace Striide\InventoryBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  public function indexAction($name)
  {
    return $this->render('StriideInventoryBundle:Default:index.html.twig', array(
      'name' => $name
    ));
  }
}
