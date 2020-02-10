<?php

namespace App\Controller;

use App\Document\User;
use App\Form\Type\RegistrationType;
use App\Service\UserService;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class AccountController extends AbstractController
{
    /**
     * @param Request     $request
     * @param UserService $userService
     * @return Response
     * @Route("/register", name="register", methods={"POST"})
     * @throws MongoDBException
     */
    public function register(Request $request, UserService $userService): Response
    {
        return $userService->register($request);
    }

    /**
     * @param Request     $request
     * @param UserService $userService
     * @return Response
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request, UserService $userService): Response
    {
        return $userService->login($request);
    }

    /**
     * @param Request     $request
     * @param UserService $userService
     * @return Response
     * @Route("/logout", name="logout", methods={"POST"})
     */
    public function logout(Request $request, UserService $userService): Response
    {
        return $userService->logout($request);
    }
}