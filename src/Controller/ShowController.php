<?php


namespace App\Controller;

use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/show")
 */
class ShowController extends AbstractController
{
    /**
     * @Route ("/list", name = "show_list")
     */
    public function index(ShowRepository $showRepository)
    {
        $shows = $showRepository->findAll();

        return $this->render('/show/show_list.html.twig',
            [
                'shows' => $shows
            ]);
    }
}