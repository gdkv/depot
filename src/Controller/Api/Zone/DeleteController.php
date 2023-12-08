<?php

namespace App\Controller\Api\Zone;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use App\Security\SensorVoter;
use App\Security\ZoneVoter;
use App\Service\Sensor\ZoneDeleteService;
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
     * Удаляет зону пользователя
     *
     * Этот запрос вернет пустой ответ в случае успешного удаления, или error если что то пошло не так
     */
    #[Route(path: '/api/zone/{id}', name: 'api.zone.delete', methods: ['DELETE'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: null
    )]
    #[OA\Tag(name: 'Зона')]
    #[Security(name: 'Bearer')]
    public function __invoke(Zone $zone, ZoneDeleteService $zoneDeleteService): JsonResponse
    {
        $this->denyAccessUnlessGranted(ZoneVoter::DELETE, $zone);

        if (($zoneDeleteService)($zone)) {
            return $this->jsonResponse([
                'success' => true,
            ]);
        } else {
            return $this->jsonResponseError();
        }
    }
}