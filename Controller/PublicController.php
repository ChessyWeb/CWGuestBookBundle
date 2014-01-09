<?php

namespace ChessyWeb\GuestBookBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ChessyWeb\GuestBookBundle\Entity\GuestMessage;
use ChessyWeb\GuestBookBundle\Form\GuestMessageType;

class PublicController extends Controller
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

    	$message = $queryCurrent->getResult();

		return $this->render('ChessyWebGuestBookBundle:Public:index.html.twig', array('messages' => $message));
    }

	public function addAction()
	{
		$message = new GuestMessage();
		$form = $this->createForm(new GuestMessageType, $message);

		$request = $this->get('request');
		if ($request->getMethod() == 'POST') {
			$form->bind($request);

			if ($form->isValid()) {
				$message->setIsValidated(0);
				$message->setDate(new \DateTime());

				$em = $this->getDoctrine()->getManager();
				$em->persist($message);
				$em->flush();


				$mail = \Swift_Message::newInstance()
			        ->setSubject('[ChessyCat] - Livre d\'Or - Vous avez un nouveau message')
			        ->setFrom('system@the-chessy-cat.fr')
			        ->setTo('contact@the-chessy-cat.fr')
			        ->setBody($this->renderView('ChessyWebGuestBookBundle:Admin:email.html.twig', array('message' => $message)), 'text/html')
    ;
				$this->get('mailer')->send($mail);

                $this->get('session')->getFlashBag()->add('info', 'Votre message a été enregistré ! Il sera bientôt publié.');

				return $this->redirect($this->generateUrl('chessy_web_guest_book_homepage'));
			} else {
				$this->get('session')->getFlashBag()->add('danger', 'Une erreur est survenue...');
			}
		}

		return $this->render('ChessyWebGuestBookBundle:Public:add.html.twig', array('form' => $form->createView()));
	}
}
