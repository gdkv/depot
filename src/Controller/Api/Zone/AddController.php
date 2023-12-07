<?php

namespace App\Controller\Api\Zone;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Zone;
use App\Exception\AppException;
use App\Model\Dto\ZoneDto;
use App\Service\Sensor\SensorCreateService;
use App\Service\Zone\ZoneCreateService;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AddController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Добавляет новую зону
     *
     * Этот запрос вернет новый зону если она валидная или error
     */
    #[Route(path: '/api/zone', name: 'api.zone.add', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new Model(type: Zone::class)
    )]
    #[OA\Tag(name: 'Зона')]
    #[Security(name: 'Bearer')]
    public function __invoke(ZoneDto $zoneDto, ZoneCreateService $zoneCreateService): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        try {
            $zone = ($zoneCreateService)($zoneDto);
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