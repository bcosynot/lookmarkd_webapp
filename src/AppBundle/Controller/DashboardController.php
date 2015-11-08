<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DashboardController extends Controller {
	
	/**
	 * @Route("/dashboard", name="dashboard")
	 */
	public function dashboardIndexAction() {
		return $this->render ( 'controller/dashboard/dashboard.html.twig' );
	}
}
