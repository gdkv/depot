<?php

namespace App\Controller\Pages\App;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route(
        path: '/{_locale}/app/report',
        name: 'app.report',
        requirements: ['_locale' => 'ru|en'],
        defaults: ['_locale' => 'ru']
    )]
    public function __invoke(): Response
    {
        return $this->render('app/report.html.twig', []);
    }
}