<?php

namespace App\Controller\Api\Sensor;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Repository\Sensor\SensorRepository;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;

class ListController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Возвращает список сенсоров пользователя
     *
     * Этот запрос вернет список всех активных и неактивных сенсоров пользователя, в будущем должны появиться
     * GET параметры в виде фильтров или заменить на POST и передавать их в теле запроса
     */
    #[Route(path: '/api/sensor', name: 'api.sensor.list', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Sensor::class))
        )
    )]
    #[OA\Tag(name: 'Сенсор')]
    #[Security(name: 'Bearer')]
    public function __invoke(Request $request, SensorRepository $repository): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->jsonResponse(
            array_map(
                function ($sensor) use ($request) {
                    return [
                        ...$sensor->__toArray(),
                        'detailUrl' => $this->generateUrl('app.sensor.detail', [
                            // '_locale' => $request->getLocale(),
                            '_locale' => 'ru',
                            'slug' => $sensor->getSlug(),
                        ])
                    ];
                },
                $repository->findBy(
                    ['user' => $this->getUser(), 'active' => true,],
                    ['position' => 'DESC',],
                    100,
                    0
                )
            ),
        );
    }
}