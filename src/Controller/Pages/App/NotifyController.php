<?php

namespace App\Controller\Pages\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotifyController extends AbstractController
{
    #[Route(
        path: '/{_locale}/app/notify',
        name: 'app.notify',
        requirements: ['_locale' => 'ru|en'],
        defaults: ['_locale' => 'ru']
    )]
    public function __invoke(): Response
    {
        return $this->render('app/notify.html.twig', []);
    }
}