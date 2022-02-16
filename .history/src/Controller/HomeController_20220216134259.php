<?php

namespace App\Controller;

use App\Form\MemoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memo = new Memo();

        $form = $this->createForm(RegistrationFormType::class, $user)
            ->add('groupe', EntityType::class, [
                'class' => Groupe::class,
                'choice_label' => 'groupeName'
            ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();


            return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('error', 'error');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
        return $this->render('home/index.html.twig', [
            'memoForm' => $form->createView(),
        ]);
    }
}
