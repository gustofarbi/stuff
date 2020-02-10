<?php


namespace App\Service;


use App\Document\ApiToken;
use App\Document\User;
use App\Form\Type\RegistrationType;
use App\Security\BaseAuthenticator;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Exception;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class UserService
{
    private DocumentManager              $dm;

    private UserPasswordEncoderInterface $passwordEncoder;

    private FormFactoryInterface         $formFactory;

    private SerializerInterface          $serializer;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(
        DocumentManager $dm,
        UserPasswordEncoderInterface $passwordEncoder,
        FormFactoryInterface $formFactory,
        SerializerInterface $serializer,
        LoggerInterface $logger
    ) {
        $this->dm              = $dm;
        $this->passwordEncoder = $passwordEncoder;
        $this->formFactory     = $formFactory;
        $this->serializer      = $serializer;
        $this->logger          = $logger;
    }

    public function login(Request $request): Response
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if ($username !== null && $password !== null) {
            $user = $this->dm->getRepository(User::class)->findOneBy(
                [
                    'username' => $username,
                ]
            );

            if ($this->passwordEncoder->isPasswordValid($user, $password)) {
                if ($this->passwordEncoder->needsRehash($user)) {
                    $newEncodedPassword = $this->passwordEncoder->encodePassword($user, $password);
                    $user->setPassword($newEncodedPassword);
                }

                $token = $this->registerToken($user);
                $msg   = [
                    'message' => [
                        'apiToken' => $token->getContent(),
                    ],
                ];

                return new JsonResponse($msg, Response::HTTP_ACCEPTED);
            }
        }

        return new JsonResponse(['message' => 'invalid credentials'], Response::HTTP_FORBIDDEN);
    }

    public function logout(Request $request): Response
    {
        if ($request->headers->has(BaseAuthenticator::AUTH_TOKEN_HEADER)) {
            $apiToken = $this->dm->getRepository(ApiToken::class)->findOneBy(
                [
                    'content' => $request->headers->get(BaseAuthenticator::AUTH_TOKEN_HEADER),
                ]
            );

            /** @var User $user */
            $user = $apiToken->getUser();
            $user->getApiTokens()->removeElement($apiToken);

            $this->dm->persist($user);
            $this->dm->flush();
        }

        return new JsonResponse(['message' => 'logged out successfully']);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws MongoDBException
     */
    public function register(Request $request): Response
    {
        $form = $this->formFactory->create(RegistrationType::class, new User());

        $form->handleRequest($request);
        $form->submit($request->request->all());

        if ($form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $user->setPassword(
                $this->passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );

            $token = $this->registerToken($user);

            $this->dm->persist($user);
            $this->dm->flush();

            $msg = [
                'message' => [
                    'apiToken' => $token->getContent(),
                ],
            ];

            return new JsonResponse($msg, Response::HTTP_CREATED);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return new JsonResponse(['message' => $errors], Response::HTTP_BAD_REQUEST);
    }

    private function registerToken(User $user): ApiToken
    {
        $token = new ApiToken($user, $this->generateTokenString());
        $user->getApiTokens()->add($token);

        return $token;
    }

    private function generateTokenString(): string
    {
        try {
            return hex2bin(random_bytes(60));
        } catch (\Throwable $t) {
            $this->logger->error('could not generate random_string');

            return sha1(uniqid());
        }
    }
}