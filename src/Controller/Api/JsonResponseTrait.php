<?php
namespace App\Controller\Api;

use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

trait JsonResponseTrait
{

    public function __construct(
        private SerializerInterface $serializer,
    ){}

    private function jsonResponseError(
        string $message = "Internal Error",
        string $code = 'internal_error',
        array $data = [],
        int $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR,
        array $headers = []
    ): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize([
                'status' => $code,
                'message' => $message,
                'data' => $data,
            ], 'json'),
            $httpCode,
            $headers,
            true
        );
    }

    private function jsonResponse(
        $data = [],
        int $httpCode = Response::HTTP_OK,
        array $headers = [],
    ): JsonResponse
    {
        return new JsonResponse(
            $this->serializer->serialize(
                $data,
                'json',
                [
                    AbstractNormalizer::IGNORED_ATTRIBUTES => [
                        '__cloner__',
                        '__initializer__',
                        '__isInitialized__',
                        'group',
                        'lazyPropertiesNames',
                        'lazyPropertiesDefaults',
                        'transitions',
                    ]
                ]
            ),
            $httpCode,
            $headers,
            true
        );
    }

}