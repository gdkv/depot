<?php

namespace App\Controller\Api\Sensor;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Repository\Sensor\SensorRepository;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    #[Route(path: '/api/sensor', name: 'api.product.list', methods: ['GET'])]
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
    public function __invoke(SensorRepository $repository): JsonResponse
    {
        return $this->jsonResponse(
            $repository->findAll()
        );
    }
}