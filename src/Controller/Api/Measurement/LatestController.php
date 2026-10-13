<?php

namespace App\Controller\Api\Measurement;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Sensor\Sensor;
use App\Exception\AppException;
use App\Exception\MeasurementsNotFoundException;
use App\Exception\SensorNotFoundException;
use App\Model\Dto\MeasurementLastDto;
use App\Repository\Sensor\SensorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LatestController extends AbstractController
{
    use JsonResponseTrait;
    /**
     * Возвращает последнее измерение сенсора плоским JSON
     *
     * Доступ защищён аутентификатором App\Security\ApiKeyAuthenticator:
     * он проверяет заголовок X-Api-Key и по MAC-адресу сенсора
     * аутентифицирует его владельца.
     */
    #[Route(path: '/api/measurement/latest', name: 'api.measurement.latest', methods: ['GET'])]
    public function __invoke(MeasurementLastDto $measurementLastDto, SensorRepository $sensorRepository): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        try {
            if (!$measurementLastDto->getSensor() instanceof Sensor) {

                throw new SensorNotFoundException(null);
            }

            $measurement = $measurementLastDto->getSensor()->getLastMeasurement();
            if (!$measurement) {

                throw new MeasurementsNotFoundException(null);
            }

        } catch (AppException $e) {

            return $this->jsonResponseError(
                $e->getMessage(),
                $e->getCode(),
                $e->getErrorData(),
                Response::HTTP_NOT_FOUND
            );
        }


        return $this->jsonResponse([
            'sensor' => $measurementLastDto->getSensor()->getMacAddress(),
            'temperature' => $measurement->getTemperature(),
            'humidity' => $measurement->getHumidity(),
            'pressure' => $measurement->getPressure(),
            'co2' => $measurement->getCo2(),
            'lux' => $measurement->getLux(),
            'decibel' => $measurement->getDecibel(),
            'createdAt' => $measurement->getCreatedAt()?->format(\DateTimeInterface::ATOM),
        ]);
    }
}
