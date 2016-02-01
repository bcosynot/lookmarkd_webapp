<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MetzWeb\Instagram\Instagram;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class CampaignController extends Controller {

	/**
	* @Route("/brand/campaign/create", name="campaign_create")
	*/
	function campaignCreateAction() {
		return $this->render('controller/campaign/create.html.twig');
	}
}
