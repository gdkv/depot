<?php

namespace App\Controller\Api\Security;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Security\User;
use App\Entity\Sensor\Sensor;
use App\Exception\AppException;
use App\Model\Dto\UserDto;
use App\Service\Security\User\UserCreateService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class RegistrationController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Регистрация нового пользователя
     *
     * Запрос зарегистрирует нового пользователя в системе
     */
    #[Route(path: '/api/registration', name: 'api.registration', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Модель User DTO',
        required: true,
        content: new Model(type: UserDto::class)
    )]
    #[OA\Response(
        response: 200,
        description: 'Модель User',
        content: new Model(type: User::class)
    )]
    #[OA\Tag(name: 'Авторизация')]
    public function __invoke(UserDto $userDto, UserCreateService $userCreateService): JsonResponse
    {
        try {
            if (
                ($userCreateService)($userDto)
            ) {
                return $this->jsonResponse(['response' => $userCreateService->getUser()]);
            }
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
    }
}