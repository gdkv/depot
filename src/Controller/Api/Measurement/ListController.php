<?php

namespace App\Controller\Api\Measurement;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Measurement;
use App\Entity\Sensor\Sensor;
use App\Model\Dto\MeasurementListDto;
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
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ListController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Возвращает список измерений
     *
     * Этот запрос вернет список измерений текущего сенсора пользователя
     */
    #[Route(path: '/api/measurement', name: 'api.measurement.list', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: '',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Measurement::class))
        )
    )]
    #[OA\RequestBody(content: new Model(type: MeasurementListDto::class))]
    #[OA\Tag(name: 'Измерения')]
    #[Security(name: 'Bearer')]
    public function __invoke(
        MeasurementListDto    $measurementDto,
        MeasurementRepository $repository,
        SensorRepository      $sensorRepository,
        ValidatorInterface    $validator
    ): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $errors = $validator->validate($measurementDto);

        if (count($errors) > 0) {
            return $this->jsonResponseError(
                "Not valid MeasurementDto",
                'not_valid_measurement_dto'
            );
        }

        $sensor = $sensorRepository->findOneBy(
            ['user' => $this->getUser(), 'active' => true, 'macAddress' => $measurementDto->getSensorMacAddress()],
        );

        if ($sensor instanceof Sensor) {
            return $this->jsonResponse(
                $repository->findByType(
                    $sensor,
                    MeasurementType::tryFrom($measurementDto->getMeasurementType()),
                    PeriodType::tryFrom($measurementDto->getPeriod())
                )
            );

        }

        return $this->jsonResponseError(
            "Sensor with mac address not found or it is not active",
            'sensor_not_found_or_unactive',
            [
                'mac address' => $measurementDto->getSensorMacAddress(),
                'type' => $measurementDto->getMeasurementType(),
                'period' => $measurementDto->getPeriod(),
            ]
        );
    }
}