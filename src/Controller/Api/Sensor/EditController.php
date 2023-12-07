<?php

namespace App\Controller\Api\Sensor;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class EditController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Изменяет сенсор пользователя
     *
     * Этот запрос вернет измененный сенсор пользователя или error если что то не так
     */
    #[Route(path: '/api/sensor/{sensorUuid}', name: 'api.sensor.edit', methods: ['PUT'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new Model(type: Sensor::class)
    )]
    #[OA\Tag(name: 'Сенсор')]
    #[Security(name: 'Bearer')]
    public function __invoke(Sensor $sensor): JsonResponse
    {
        $this->denyAccessUnlessGranted('SENSOR_EDIT', $sensor);

        return $this->jsonResponse(
            $sensor
        );
    }
}