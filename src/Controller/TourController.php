<?php


namespace App\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Show;
use App\Entity\Tour;
use App\Form\ReservationType;
use App\Repository\TourRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


/**
 * @Route ("/tour")
 */
class TourController extends AbstractController
{
    /**
     * @Route ("/list", name = "tour_list")
     */
    public function index(TourRepository $tourRepository)
    {
        $tours = $tourRepository->findAll();

        return $this->render('/tour/tour_list.html.twig',
            [
                'tours' => $tours
            ]);
    }

    /**
     * @Route ("/{name}/{place}/{id}/details", name = "tour_details")
     */
    public function show(Tour $tour)
    {
        $shows = $tour->getShows();

        return $this->render('/tour/tour_details.html.twig',
            [
                'tour' => $tour,
                'shows' => $shows,
            ]);
    }

    /**
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @Route ("/{name}/{place}/reservation", name="tour_reservation")
     */
    public function reservation(Request $request, \Swift_Mailer $mailer, Tour $tour, ObjectManager $manager)
    {

        $form = $this->createForm(
            ReservationType::class
        );
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $totalPrice = $form->getData()['tickets'] * $tour->getPrice();

            $tour->setTickets($tour->getTickets() - $form->getData()['tickets']);
            $manager->flush();

            $message = (new \Swift_Message('Wild circus reservation'))
                ->setFrom('wild-circus@yopmail.com')
                ->setTo($form->getData()['mail'])
                ->setBody(
                    $this->renderView('email/reservation_confirm.html.twig',
                        [
                            'data' => $form->getData(),
                            'tour' => $tour,
                            'totalPrice' => $totalPrice
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('success', 'Votre commande a bien été validée, un email vous a été envoyé');
        }
        return $this->render('tour/reservation.html.twig',
            [
                'tour' => $tour,
                'form' => $form->createView(),

            ]);
    }


}