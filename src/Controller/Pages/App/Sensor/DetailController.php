<?php

namespace App\Controller\Pages\App\Sensor;

use App\Entity\Sensor\Sensor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DetailController extends AbstractController
{
    #[Route(
        path: '/{_locale}/app/sensor/{slug}',
        name: 'app.sensor.detail',
        requirements: ['_locale' => 'ru|en'],
        defaults: ['_locale' => 'ru']
    )]
    public function __invoke(Sensor $sensor): Response
    {
        return $this->render('app/sensor/detail.html.twig', ['sensor' => $sensor]);
    }
}