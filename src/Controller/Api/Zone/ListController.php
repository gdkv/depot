<?php

namespace App\Controller\Api\Zone;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use App\Repository\Sensor\SensorRepository;
use App\Repository\Sensor\ZoneRepository;
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
     * Возвращает список зон пользователя
     *
     * Этот запрос вернет список всех активных и неактивных зон пользователя, в будущем должны появиться
     * GET параметры в виде фильтров или заменить на POST и передавать их в теле запроса
     */
    #[Route(path: '/api/zone', name: 'api.zone.list', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Zone::class))
        )
    )]
    #[OA\Tag(name: 'Зона')]
    #[Security(name: 'Bearer')]
    public function __invoke(ZoneRepository $repository): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return $this->jsonResponse(
            $repository->findBy(
                ['user' => $this->getUser(), 'active' => true,],
                ['position' => 'DESC',],
                100,
                0
            ),
        );
    }
}