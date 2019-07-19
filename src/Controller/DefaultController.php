<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @Route("/contact", name = "contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)

    {
        $form = $this->createForm(
            ContactType::class
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message('Wild Circus nouveau message'))
                ->setFrom($form->getdata()['Mail'])
                ->setTo($this->getParameter('mailer_to'))
                ->setBody(
                    $this->renderView('email/contact.html.twig',
                        [
                            'user' => $form->getData()
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);
            $this->addFlash('success', 'Votre message a bien été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact.html.twig',
            [
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route ("/information", name = "infos")
     */
    public function information()
    {
        return $this->render('information.html.twig');
    }
}