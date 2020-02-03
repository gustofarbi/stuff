<?php


namespace App\Controller;


use App\Document\User;
use App\Form\Model\Registration;
use App\Form\Type\RegistrationType;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\MongoDBException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="account", methods={"GET"})
     */
    public function account(): Response
    {
        $form = $this->createForm(RegistrationType::class, new Registration());

        return $this->render(
            'account/account.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @throws MongoDBException
     * @Route("/create", name="create", methods={"POST"})
     */
    public function create(
        DocumentManager $dm,
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder
    ): Response {
        $form = $this->createForm(RegistrationType::class, new Registration());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Registration $registration */
            $registration = $form->getData();

            $user = $registration->getUser();
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
                )
            );

            $dm->persist($user);
            $dm->flush();

            return $this->redirectToRoute('all');
        }

        return $this->redirectToRoute('account');
    }

    /**
     * @Route("/all", name="all")
     */
    public function all(DocumentManager $dm): Response
    {
        return $this->render(
            'account/all.html.twig',
            [
                'users' => $dm->getRepository(User::class)->findAll(),
            ]
        );
    }
}