<?php
namespace Striide\InventoryBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();
    $items = $em->getRepository('StriideInventoryBundle:Item')->findAll();

    return $this->render('StriideInventoryBundle:Default:index.html.twig', array(
      'items' => $items,
      'crumbs' => array(array('href' => $this->get('router')->generate('StriideInventoryBundle_homepage'),
                              'label' => $this->get('translator')->trans('Inventory')))
    ));
  }
}
