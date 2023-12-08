<?php

namespace App\Controller\Api\Zone;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Entity\Sensor\Zone;
use App\Exception\AppException;
use App\Model\Dto\SensorDto;
use App\Model\Dto\ZoneDto;
use App\Security\SensorVoter;
use App\Security\ZoneVoter;
use App\Service\Sensor\SensorEditService;
use App\Service\Zone\ZoneEditService;
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
     * Изменяет зону пользователя
     *
     * Этот запрос вернет измененную зону пользователя или error если что то не так
     */
    #[Route(path: '/api/zone/{id}', name: 'api.zone.edit', methods: ['PUT'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new Model(type: Zone::class)
    )]
    #[OA\Tag(name: 'Зона')]
    #[Security(name: 'Bearer')]
    public function __invoke(
        Zone $zone,
        ZoneDto $zoneDto,
        ZoneEditService $zoneEditService,
    ): JsonResponse
    {
        $this->denyAccessUnlessGranted(ZoneVoter::EDIT, $zone);

        try {
            $zone = ($zoneEditService)($zone, $zoneDto);
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
            $zone
        );
    }
}