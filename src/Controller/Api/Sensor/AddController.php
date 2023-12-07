<?php

namespace App\Controller\Api\Sensor;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Exception\AppException;
use App\Model\Dto\SensorDto;
use App\Service\Sensor\SensorCreateService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class AddController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Добавляет новый сенсор
     *
     * Этот запрос вернет новый сенсор если он валидный или error
     */
    #[Route(path: '/api/sensor', name: 'api.sensor.add', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new Model(type: Sensor::class)
    )]
    #[OA\Tag(name: 'Сенсор')]
    #[Security(name: 'Bearer')]
    public function __invoke(SensorDto $sensorDto, SensorCreateService $sensorCreateService): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        try {
            $sensor = ($sensorCreateService)($sensorDto);
        } catch (AppException $e) {
            return $this->jsonResponseError(
                $e->getErrorMessage(),
                $e->getErrorCode(),
                $e->getErrorData(),
                $e->getResponseCode()
            );
        } catch (\Throwable $e) {
            return $this->jsonResponseError(
                $e->getMessage(),
                $e->getCode(),
            );
        }

        return $this->jsonResponse(
            $sensor
        );
    }
}