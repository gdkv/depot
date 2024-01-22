<?php

namespace App\Controller\Api\Limit;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Limit;
use App\Exception\AppException;
use App\Model\Dto\LimitsDto;
use App\Service\Limit\LimitCreateService;
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
     * Добавляет ограничения на сенсор
     *
     * Этот запрос добавит новые ограничения на сенсор по заданному типу измерения
     */
    #[Route(path: '/api/limit', name: 'api.limit.add', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Модель ограничения',
        required: true,
        content: new Model(type: LimitDto::class)
    )]
    #[OA\Response(
        response: 200,
        description: '',
        content: new Model(type: Limit::class)
    )]
    #[OA\Tag(name: 'Сенсор')]
    #[Security(name: 'Bearer')]
    public function __invoke(LimitsDto $limitsDto, LimitCreateService $limitCreateService): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        try {
            $limit = ($limitCreateService)($limitsDto);
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
            $limit
        );
    }
}