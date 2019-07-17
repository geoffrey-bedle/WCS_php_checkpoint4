<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GaleryController extends AbstractController

{
    /**
     * @Route("galery/categories",name = "galery_categories")
     */
public function showCategories(){
    return $this->render('galery/galery_category.html.twig');
}
}