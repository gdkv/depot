<?php

namespace App\Security;

use App\Entity\Sensor\Sensor;
use App\Entity\Security\User;
use App\Repository\Sensor\SensorRepository;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class ApiKeyAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    private const HEADER_KEY = 'X-Api-Key';
    private const QUERY_MAC = 'sensor';

    public function __construct(
        private readonly SensorRepository $sensorRepository,
        #[Autowire('%env(HA_API_KEY)%')]
        private readonly string $apiKey,
    ) {}

    /**
     * Аутентификатор включается только если в запросе есть заголовок X-Api-Key.
     */
    public function supports(Request $request): ?bool
    {
        return $request->headers->has(self::HEADER_KEY);
    }

    public function authenticate(Request $request): Passport
    {
        $providedKey = $request->headers->get(self::HEADER_KEY);

        if (!is_string($providedKey) || $this->apiKey === '' || !hash_equals($this->apiKey, $providedKey)) {
            throw new CustomUserMessageAuthenticationException('Invalid or missing X-Api-Key header');
        }

        $mac = $this->resolveMac($request);
        if ($mac === null) {
            throw new CustomUserMessageAuthenticationException('Sensor MAC (query param or body field "sensor") is required.');
        }

        $sensor = $this->sensorRepository->findOneBy(['macAddress' => $mac, 'active' => true]);
        if (!$sensor instanceof Sensor) {
            throw new CustomUserMessageAuthenticationException('Sensor not found or inactive.');
        }

        $user = $sensor->getUser();
        if (!$user instanceof User) {
            throw new CustomUserMessageAuthenticationException('Sensor has no owner.');
        }

        // Пробрасываем сенсор дальше, чтобы контроллер не искал его повторно.
        $request->attributes->set('sensor', $sensor);

        return new SelfValidatingPassport(
            new UserBadge($user->getUserIdentifier(), static fn (): User => $user)
        );
    }

    /**
     * MAC берём из query (GET /api/measurement/latest),
     * а если там пусто — из JSON-тела (PUT /api/measurement).
     */
    private function resolveMac(Request $request): ?string
    {
        $mac = $request->query->get(self::QUERY_MAC);
        if (is_string($mac) && trim($mac) !== '') {
            return trim($mac);
        }

        try {
            $data = $request->toArray();
        } catch (\JsonException) {
            return null;
        }

        $mac = $data[self::QUERY_MAC] ?? null;

        return is_string($mac) && trim($mac) !== '' ? trim($mac) : null;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(
            [
                'status' => 'unauthorized',
                'message' => $exception->getMessageKey(),
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    /**
     * Возвращает JSON-401, если аутентификатор не сработал вовсе (нет заголовка X-Api-Key).
     */
    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new JsonResponse(
            [
                'status' => 'unauthorized',
                'message' => 'Authentication required (send X-Api-Key header and sensor Mac address).',
            ],
            Response::HTTP_UNAUTHORIZED
        );
    }
}
