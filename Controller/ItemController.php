<?php

namespace Striide\InventoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Striide\InventoryBundle\Entity\Item;
use Striide\InventoryBundle\Form\ItemType;

/**
 * Item controller.
 *
 */
class ItemController extends Controller
{
    /**
     * Lists all Item entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('StriideInventoryBundle:Item')->findAll();

        return $this->render('StriideInventoryBundle:Item:index.html.twig', array(
            'entities' => $entities
        ));
    }

    /**
     * Finds and displays a Item entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StriideInventoryBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StriideInventoryBundle:Item:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'crumbs' => array(
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_homepage'),
                                'label' => $this->get('translator')->trans('Inventory')),
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_admin_item_show', array('id' => $entity->getId())),
                                'label' => $this->get('translator')->trans('Item'))
                        )

        ));
    }

    /**
     * Displays a form to create a new Item entity.
     *
     */
    public function newAction()
    {
        $entity = new Item();
        $form   = $this->createForm(new ItemType(), $entity);

        return $this->render('StriideInventoryBundle:Item:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'json_types' => json_encode($this->get('striide_inventory.types')->getInventoryTypesArray()),
            'form_theme' => 'StriideTwitterbootstrapBundle:Form:form_theme.html.twig',
            'crumbs' => array(
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_homepage'),
                                'label' => $this->get('translator')->trans('Inventory')),
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_admin_item_new'),
                                'label' => $this->get('translator')->trans('Create new Item'))
                        )
        ));
    }

    /**
     * Creates a new Item entity.
     *
     */
    public function createAction()
    {
        $entity  = new Item();
        $request = $this->getRequest();
        $form    = $this->createForm(new ItemType(), $entity);
        $form->handleRequest ($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $photo = $entity->getPhoto();
            if(!empty($photo))
            {
              $media = $this->get('striide_inventory.service.media')->save($entity->getPhoto());
              $entity->setPhoto($media->getId());
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('StriideInventoryBundle_admin_item_show', array('id' => $entity->getId())));

        }

        return $this->render('StriideInventoryBundle:Item:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'json_types' => json_encode($this->get('striide_inventory.types')->getInventoryTypesArray()),
            'form_theme' => 'StriideTwitterbootstrapBundle:Form:form_theme.html.twig',
            'crumbs' => array(
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_homepage'),
                                'label' => $this->get('translator')->trans('Inventory')),
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_admin_item_new'),
                                'label' => $this->get('translator')->trans('Create new Item'))
                        )
        ));
    }

    /**
     * Displays a form to edit an existing Item entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StriideInventoryBundle:Item')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $editForm = $this->createForm(new ItemType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('StriideInventoryBundle:Item:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'json_types' => json_encode($this->get('striide_inventory.types')->getInventoryTypesArray()),
            'edit_form_theme' => 'StriideTwitterbootstrapBundle:Form:form_theme.html.twig',
            'delete_form' => $deleteForm->createView(),
            'crumbs' => array(
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_homepage'),
                                'label' => $this->get('translator')->trans('Inventory')),
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_admin_item_edit', array('id' => $entity->getId())),
                                'label' => $this->get('translator')->trans('Edit Item'))
                        )
        ));
    }

    /**
     * Edits an existing Item entity.
     *
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('StriideInventoryBundle:Item')->find($id);
        $photo = $entity->getPhoto();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Item entity.');
        }

        $editForm   = $this->createForm(new ItemType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->handleRequest($request);

        if ($editForm->isValid())
        {
          $p = $entity->getPhoto();
          if(empty($p) && !empty($photo))
          {
            $entity->setPhoto($photo);
          }
          else if(!empty($p))
          {
            $media = $this->get('striide_inventory.service.media')->save($entity->getPhoto());
            $entity->setPhoto($media->getId());
          }

          $em->persist($entity);
          $em->flush();

          return $this->redirect($this->generateUrl('StriideInventoryBundle_admin_item_show', array('id' => $id)));
        }

        return $this->render('StriideInventoryBundle:Item:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'json_types' => json_encode($this->get('striide_inventory.types')->getInventoryTypesArray()),
            'edit_form_theme' => 'StriideTwitterbootstrapBundle:Form:form_theme.html.twig',
            'delete_form' => $deleteForm->createView(),
            'crumbs' => array(
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_homepage'),
                                'label' => $this->get('translator')->trans('Inventory')),
                          array('href' => $this->get('router')->generate('StriideInventoryBundle_admin_item_edit', array('id' => $entity->getId())),
                                'label' => $this->get('translator')->trans('Edit Item'))
                        )
        ));
    }

    /**
     * Deletes a Item entity.
     *
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('StriideInventoryBundle:Item')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Item entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('StriideInventoryBundle_homepage'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
