<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;

class DefaultController extends Controller
  {

  /**
   * @Route("/", name="homepage")
   */
  public function indexAction(Request $request)
  {
    $newsrepository = $this->getDoctrine()->getRepository('AppBundle:Newspost');
    $newsitems = $newsrepository->findBy(array(), array('datum' => 'DESC'));
    $userrepository = $this->getDoctrine()->getRepository('AppBundle:User');
    $users = $userrepository->findAll();
    
    if($request->getSession()->get('user'))
    {
      return $this->render('default/index.html.twig', array(
        'newsitems'     => $newsitems,
        'users'         => $users,
        'dbuser'        => $request->getSession()->get('user')
      ));
    }

    return $this->render('default/index.html.twig', array(
          'newsitems' => $newsitems,
          'users' => $users
    ));
  }

  }
