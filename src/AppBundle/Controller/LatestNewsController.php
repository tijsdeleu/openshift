<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;

class LatestNewsController extends Controller
  {

  /**
   * @Route("/latestnews", name="latestnews")
   */
  public function indexAction(Request $request)
  {
    $newsrepository = $this->getDoctrine()->getRepository('AppBundle:Newspost');
    $newsitems = $newsrepository->findAll();
    return $this->render('news/latestnews.html.twig', array(
      'newsitems'   => $newsitems
    ));
  }
  }