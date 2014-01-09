<?php

namespace ChessyWeb\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ChessyWeb\GuestBookBundle\Entity\GuestMessage;

class AdminController extends Controller
{
	public function indexAction()
    {
    	$queryCurrent = $this->getDoctrine()
                 		->getManager()
                     	->getRepository('ChessyWebGuestBookBundle:GuestMessage')
                     	->createQueryBuilder('gm')
                     	->where('gm.isValidated = 1')
                     	->orderBy('gm.date', 'DESC')
                     	->getQuery();

    	$validatedMessages = $queryCurrent->getResult();

    	$queryCurrent = $this->getDoctrine()
                 		->getManager()
                     	->getRepository('ChessyWebGuestBookBundle:GuestMessage')
                     	->createQueryBuilder('gm')
                     	->where('gm.isValidated = 0')
                     	->orderBy('gm.date', 'DESC')
                     	->getQuery();

    	$unvalidatedMessages = $queryCurrent->getResult();

		return $this->render('ChessyWebGuestBookBundle:Admin:index.html.twig', array('validatedMessages' => $validatedMessages, 'unvalidatedMessages' => $unvalidatedMessages));
    }

	public function deleteAction(GuestMessage $gm)
	{
		$em = $this->getDoctrine()
                 		->getManager();

		if ($gm == null) {
			throw $this->createNotFoundException('GuestMessage[id='.$gm->getId().'] inexistant');
		}

		$em->remove($gm);
		$em->flush();

		$this->get('session')->getFlashBag()->add('danger', 'Le message a été supprimé ! Niark, niark !');

		return $this->redirect($this->generateUrl('chessy_web_guest_book_admin_index'));
	}

	public function toggleAction(GuestMessage $gm)
	{
		$em = $this		->getDoctrine()
                 		->getManager();

		if ($gm == null) {
			throw $this->createNotFoundException('GuestMessage[id='.$id.'] inexistant');
		}

		if($gm->getIsValidated() == 1)
		{
			$gm->setIsValidated(0);
			$this->get('session')->getFlashBag()->add('info', 'Le message a été mis de côté ! Hum ...');
		} else {
			$gm->setIsValidated(1);
			$this->get('session')->getFlashBag()->add('success', 'Le message a été validé ! Yeah !');
		}
		$em->flush();

		return $this->redirect($this->generateUrl('chessy_web_guest_book_admin_index'));
	}
}
