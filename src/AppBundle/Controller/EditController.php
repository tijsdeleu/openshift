<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;

class EditController extends Controller
  {

  /**
   * @Route("/editpost/{slug}", name="editpost")
   */
  public function indexAction(Request $request, $slug)
  {
    $session = $request->getSession();
    if(!$session->get('user'))
    {
      return $this->redirectToRoute('homepage');
    }
    
    $dbuser = new User();
    $dbuser = $session->get('user');
    if($dbuser->getAdmin() != 3)
    {
      return $this->redirectToRoute('homepage');
    }
    
    $post = new Newspost();
    $newsrepository = $this->getDoctrine()->getRepository('AppBundle:Newspost');
    $post = $newsrepository->find($slug);
    $newsitems = $newsrepository->findBy(array(),array('datum' => 'DESC'));
    
    $form = $this->createFormBuilder($post)
        ->add('titel', 'text', array('data' => $post->getTitel()))
        ->add('inhoud', 'textarea', array(
          'attr'  =>  array('label' => 'test'),
          'data'  =>  $post->getInhoud()
        ))
        ->add('bevestig', 'submit', array('label' => 'Bevestig'))
        ->getForm();
    
    $form->handleRequest($request);
    if($form->isValid())
    {
      $em = $this->getDoctrine()->getManager();
      $em->flush();
      return $this->redirect('/');
    }
    
    return $this->render('post/editpost.html.twig', array(
        'form'    => $form->createView(),
        'dbuser'  => $dbuser,
        'newsitems' => $newsitems
    ));
  }
  
  /**
   * @Route("/deletepost/{slug}", name="deletepost")
   */
  public function deleteAction(Request $request, $slug)
  {
    $session = $request->getSession();
    if(!$session->get('user'))
    {
      return $this->redirectToRoute('homepage');
    }
    
    $dbuser = new User();
    $dbuser = $session->get('user');
    if($dbuser->getAdmin() != 3)
    {
      return $this->redirectToRoute('homepage');
    }
    
    $post = new Newspost();
    $newsrepository = $this->getDoctrine()->getRepository('AppBundle:Newspost');
    $post = $newsrepository->find($slug);
    $em = $this->getDoctrine()->getManager();
    $em->remove($post);
    $em->flush();
    return $this->redirectToRoute('homepage');
  }

  }
