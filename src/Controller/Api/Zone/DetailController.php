<?php

namespace App\Controller\Api\Zone;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use App\Repository\Sensor\SensorRepository;
use App\Security\SensorVoter;
use App\Security\ZoneVoter;
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
     * Возвращает зону пользователя
     *
     * Этот запрос вернет список всех активные и неактивные зоны пользователя, в будущем должны появиться
     * GET параметры в виде фильтров или заменить на POST и передавать их в теле запроса
     */
    #[Route(path: '/api/zone/{id}', name: 'api.zone.detail', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new Model(type: Zone::class)
    )]
    #[OA\Tag(name: 'Зона')]
    #[Security(name: 'Bearer')]
    public function __invoke(Zone $zone): JsonResponse
    {
        $this->denyAccessUnlessGranted(ZoneVoter::VIEW, $zone);

        return $this->jsonResponse(
            $zone
        );
    }
}