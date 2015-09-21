<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Newspost;

class LogoutController extends Controller
  {

  /**
   * @Route("/logout", name="logout")
   */
  public function indexAction(Request $request)
  {
    $session = $request->getSession();
    $session->clear();
    
    return $this->redirect('/');
  }

  }
