<?php

namespace App\Controller\Pages;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route(
        path: '/{_locale}/about',
        name: 'app.about',
        requirements: ['_locale' => 'ru|en'],
        defaults: ['_locale' => 'ru']
    )]
    public function __invoke(): Response
    {
        return $this->render('pages/about.html.twig', []);
    }
}