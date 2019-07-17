<?php


namespace App\Controller;


use App\Repository\ArtistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Artist;

/**
 * @Route("/artist")
 */
class ArtistController extends AbstractController
{
    /**
     * @Route("/", name="artist_list")
     */
public function index(ArtistRepository $artistRepository)
{
    $artists = $artistRepository->findAll();

    return $this->render('artist/artist_index.html.twig',
        [
            'artists' => $artists
        ]);
}

}