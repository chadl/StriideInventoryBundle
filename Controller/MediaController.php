<?php

namespace Striide\InventoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MediaController extends Controller
{
  public function showAction($id, $format = 'reference')
  {
    $media = $this->get('sonata.media.manager.media')->findOneBy(array('id' => $id));;
    return $this->render('StriideInventoryBundle:Media:_show.html.twig', array(
      'media' => $media,
      'format' => $format
    ));
  }
}
