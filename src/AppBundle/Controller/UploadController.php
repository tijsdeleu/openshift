<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;
use AppBundle\Entity\Image;

class UploadController extends Controller
  {

  /**
   * @Route("/upload", name="upload")
   */
  public function indexAction(Request $request)
  {
    $session = $request->getSession();
    $dbuser = $session->get('user');

    
    if ($dbuser->getAdmin()!=3)
    {
      return $this->redirect('/');
    }

    if ($dbuser->getAdmin()==3)
    {
      $image = new Image();
      $formUpload = $this->createFormBuilder($image)
          ->add('name')
          ->add('file')
          ->add('upload', 'submit', array('label' => 'upload'))
          ->getForm();
      
      $formUpload->handleRequest($request);

      if ($formUpload->isValid())
      {
        $em = $this->getDoctrine()->getManager();

        $em->persist($image);
        $em->flush();
      }
      
      return $this->render('upload.html.twig', array(
        'formUpload'  => $formUpload->createView(),
        'dbuser'      => $dbuser
        ));
    }

    return $this->render('upload.html.twig',array(
      'dbuser'  => $dbuser
    ));
  }


  }
