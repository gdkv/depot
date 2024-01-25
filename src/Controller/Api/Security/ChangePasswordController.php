<?php

namespace App\Controller\Api\Security;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Security\User;
use App\Entity\Sensor\Sensor;
use App\Exception\AppException;
use App\Model\Dto\ChangePasswordDto;
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

class ChangePasswordController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Смена пароля пользователя
     *
     * Запрос сменит пароль пользователя или вернет ошибку если что то не так
     */
    #[Route(path: '/api/change-password', name: 'api.change.password', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Модель смены пароля',
        required: true,
        content: new Model(type: ChangePasswordDto::class)
    )]
    #[OA\Response(
        response: 200,
        description: 'Модель User',
        content: new Model(type: User::class)
    )]
    #[OA\Tag(name: 'Авторизация')]
    public function __invoke(
        ChangePasswordDto $changePasswordDto,
        UserChangePasswordService $userChangePasswordService
    ): JsonResponse
    {
        try {
            ($userChangePasswordService)($changePasswordDto);
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

        return $this->jsonResponse(['response' => $userChangePasswordService->getUser()]);
    }
}