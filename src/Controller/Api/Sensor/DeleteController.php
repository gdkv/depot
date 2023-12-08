<?php

namespace App\Controller\Api\Sensor;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Security\SensorVoter;
use App\Service\Sensor\SensorDeleteService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class DeleteController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Удаляет сенсор пользователя
     *
     * Этот запрос вернет пустой ответ в случае успешного удаления, или error если что то пошло не так
     */
    #[Route(path: '/api/sensor/{id}', name: 'api.sensor.delete', methods: ['DELETE'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: null
    )]
    #[OA\Tag(name: 'Сенсор')]
    #[Security(name: 'Bearer')]
    public function __invoke(Sensor $sensor, SensorDeleteService $sensorDeleteService): JsonResponse
    {
        $this->denyAccessUnlessGranted(SensorVoter::DELETE, $sensor);

        if (($sensorDeleteService)($sensor)) {
            return $this->jsonResponse([
                'success' => true,
            ]);
        } else {
            return $this->jsonResponseError();
        }
    }
}