<?php

namespace App\Controller\Api\Measurement;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Measurement;
use App\Entity\Sensor\Sensor;
use App\Exception\MeasurementCreateException;
use App\Model\Dto\MeasurementAddDto;
use App\Model\Dto\MeasurementListDto;
use App\Model\Enum\MeasurementType;
use App\Model\Enum\PeriodType;
use App\Repository\Sensor\MeasurementRepository;
use App\Repository\Sensor\SensorRepository;
use App\Service\Measurement\MeasurementCreateService;
use Nelmio\ApiDocBundle\Annotation\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

class AddController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Добавляет пачку измерений
     *
     * Этот запрос запишет список измерений для сенсора пользователя
     */
    #[Route(path: '/api/measurement', name: 'api.measurement.add', methods: ['PUT'])]
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
    public function __invoke(
        MeasurementAddDto     $measurementDto,
        MeasurementCreateService $measurementCreateService,
        ValidatorInterface    $validator
    ): JsonResponse
    {

        $errors = $validator->validate($measurementDto);

        if (count($errors) > 0) {
            return $this->jsonResponseError(
                "Not valid MeasurementDto",
                'not_valid_measurement_dto',
                [ ...$errors, ],
            );
        }

        try {
            $measurement = ($measurementCreateService)($measurementDto);
        } catch (MeasurementCreateException $e) {

            return $this->jsonResponseError(
                $e->getMessage(),
                $e->getCode(),
                [
                    'mac address' => $measurementDto->getSensor()->getMacAddress(),
                ]
            );
        } catch (Throwable $e) {
            return $this->jsonResponseError(
                $e->getMessage(),
                $e->getCode(),
            );
        }


        return $this->jsonResponse($measurement);
    }
}