<?php

namespace App\Controller\Api\Sensor;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Repository\Sensor\SensorRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class DetailController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Возвращает сенсор пользователя
     *
     * Этот запрос вернет список всех активных и неактивных сенсоров пользователя, в будущем должны появиться
     * GET параметры в виде фильтров или заменить на POST и передавать их в теле запроса
     */
    #[Route(path: '/api/sensor/{sensorUuid}', name: 'api.sensor.detail', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new Model(type: Sensor::class)
    )]
    #[OA\Tag(name: 'Сенсор')]
    #[Security(name: 'Bearer')]
    public function __invoke(Sensor $sensor): JsonResponse
    {
        $this->denyAccessUnlessGranted('SENSOR_VIEW', $sensor);

        return $this->jsonResponse(
            $sensor
        );
    }
}