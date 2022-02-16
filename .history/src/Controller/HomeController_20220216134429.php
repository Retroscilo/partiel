<?php

namespace App\Controller;

use App\Entity\Memo;
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

        $form = $this->createForm(MemoFormType::class, $memo);
  
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($memo);
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
