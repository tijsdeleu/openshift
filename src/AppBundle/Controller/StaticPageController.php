<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;
use AppBundle\Controller\SessionController;


class StaticPageController extends Controller
  {
  /**
   * @Route("/visie", name="visie")
   */
  public function visieAction(Request $request)
  {
    return $this->render('pages/visie.html.twig');
  }
  
  }