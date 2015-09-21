<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;

class SessionController extends Controller
  {

  /**
   * @Route("/session", name="session")
   */
  public function indexAction(Request $request)
  {
    $session = $request->getSession();
    $dbuser = $session->get('user');
    if ($dbuser)
    {
      return $this->render('session.html.twig', array(
            'dbuser' => $dbuser
      ));
    }
    
    if (!$dbuser)
    {
      
      $warning="";
      $user = new User();
      $form = $this->createFormBuilder($user)
          ->setAction($this->generateUrl('session'))
          ->add('username', 'text')
          ->add('password', 'password')
          ->add('login', 'submit', array('label' => 'login'))
          ->getForm();
      
      // VANG LOGINFORM OP
      $form->handleRequest($request);
      if ($form->isValid())
      {
        $userrepository = $this->getDoctrine()->getRepository('AppBundle:User');
        $dbuser = $userrepository->findOneBy(array('username' => $user->getUsername(), 'password' => $user->getPassword()));
        if (!$dbuser)
        {
          $warning = "Gebruikersnaam en/of paswoord niet correct";
        }
        if ($dbuser)
        {
          $session->set('user', $dbuser);
          return $this->redirect('/');
        }
      }
      
    }
      return $this->render('session.html.twig', array(
            'form' => $form->createView(),
            'warning' => $warning
      ));
    }
   
  }

  
