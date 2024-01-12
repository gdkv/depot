<?php

namespace App\Controller\Api\Measurement;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Measurement;
use App\Entity\Sensor\Sensor;
use App\Model\Dto\MeasurementDto;
use App\Model\Enum\MeasurementType;
use App\Model\Enum\PeriodType;
use App\Repository\Sensor\MeasurementRepository;
use App\Repository\Sensor\SensorRepository;
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
     * Возвращает список измерений
     *
     * Этот запрос вернет список измерений текущего сенсора пользователя
     */
    #[Route(path: '/api/measurement', name: 'api.measurement.list', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Measurement::class))
        )
    )]
    #[OA\RequestBody(content: new Model(type: MeasurementDto::class))]
    #[OA\Tag(name: 'Измерения')]
    #[Security(name: 'Bearer')]
    public function __invoke(MeasurementDto $measurementDto, MeasurementRepository $repository, SensorRepository $sensorRepository): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $sensor = $sensorRepository->findAll();

        $sql = $repository->findByType(
            $sensor[0],
            MeasurementType::Temperature,
            PeriodType::Year
        );

        //
        dd([
            'sql' => $sql,
            'param' => [
                'sensor' => $sensor[0]->getId(),
                'type' => MeasurementType::Temperature,
                'period' => PeriodType::Year
            ]
        ]);

        return $this->jsonResponse(
            $repository->findByType(
                $sensor[2]->getId(),
                MeasurementType::Temperature,
                PeriodType::Hour
            )
        );
    }
}