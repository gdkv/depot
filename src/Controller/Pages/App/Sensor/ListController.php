<?php

namespace App\Controller\Pages\App\Sensor;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    #[Route(
        path: '/{_locale}/app/sensor',
        name: 'app.sensor.list',
        requirements: ['_locale' => 'ru|en'],
        defaults: ['_locale' => 'ru']
    )]
    public function __invoke(): Response
    {
        return $this->render('app/sensor/list.html.twig', []);
    }
}