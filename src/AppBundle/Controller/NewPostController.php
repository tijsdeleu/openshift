<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;
use AppBundle\Entity\Image;

class NewPostController extends Controller
  {

  /**
   * @Route("/newpost", name="newpost")
   */
  public function indexAction(Request $request)
  {
    $session = $request->getSession();
    if(!$session->get('user'))
    {
      $this->redirect('/');
    }
    if($session->get('user')->getAdmin() != 3)
    {
      $this->redirect('/');
    }
    
    $newsrepository = $this->getDoctrine()->getRepository('AppBundle:Newspost');
    $newsitems = $newsrepository->findBy(array(),array('datum' => 'DESC'));
    
    $dbuser = $session->get('user');
    
    // FORM NEW POST
    $newpost = new Newspost();
    $form = $this->createFormBuilder($newpost)
        ->add('titel', 'text')
        ->add('inhoud', 'textarea', array(
          'attr'  =>  array('label' => 'test')
        ))
        ->add('bevestig', 'submit', array('label' => 'bevestig'))
        ->getForm();
    
    $form->handleRequest($request);
    if($form->isValid())
    {
      $newpost->setAuteurid($dbuser->getId());
      $newpost->setDatum(new \DateTime());
      $em = $this->getDoctrine()->getManager();
      $em->persist($newpost);
      $em->flush();
      return $this->redirect('/');
    }
    
    $imgrepo = $this->getDoctrine()->getRepository('AppBundle:Image');
     $images = $imgrepo->findAll();
    
    return $this->render('post/newpost.html.twig',array(
        'newsitems'     => $newsitems,
        'dbuser'        => $dbuser,
        'form'          => $form->createView(),
        'images'        => $images
    ));
  }
  }