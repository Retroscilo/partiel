<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoType;
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

        $form = $this->createForm(MemoType::class, $memo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $memo->setExpirationDate($form->get('expirationDate')->getData());
            $entityManager->persist($memo);
            $entityManager->flush();

            return $this->redirectToRoute('memo', ["id" => $memo->getId()]);
        } else {
            $this->addFlash('error', 'error');
        }

        return $this->render('home/index.html.twig', [
            'memoForm' => $form->createView(),
        ]);
    }
}
