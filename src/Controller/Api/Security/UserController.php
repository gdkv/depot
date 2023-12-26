<?php

namespace App\Controller\Api\Security;

use App\Controller\Api\JsonResponseTrait;
use App\Entity\Security\User;
use App\Entity\Sensor\Sensor;
use App\Exception\AppException;
use App\Model\Dto\UserDto;
use App\Service\Security\User\UserCreateService;
use App\Service\Security\User\UserGetService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Attributes as OA;

class UserController extends AbstractController
{
    use JsonResponseTrait;

    /**
     * Получить пользователя
     *
     * В ответ вернется текущий пользователь или пустой ответ если пользователь не авторизован
     */
    #[Route(path: '/api/user', name: 'api.user', methods: ['POST'])]
    #[OA\Response(
        response: 200,
        description: 'Модель User',
        content: new Model(type: User::class)
    )]
    #[OA\Tag(name: 'Авторизация')]
    public function __invoke(UserGetService $userGetService): JsonResponse
    {
        try {
            $currentUser = ($userGetService)();
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

        return $this->jsonResponse(['response' => $currentUser, ]);
    }
}