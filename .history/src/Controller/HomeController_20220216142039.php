<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $memo = new Memo();

        $form = $this->createForm(MemoType::class, $memo);

        $form->handleRequest($request)
            ->add('expirationDate', NumberType::class, [
                'input' => 'number',
                "constraints" =>  new Assert\Range([
                    'min' => 0,
                    'max' => 180,
                    'notInRangeMessage' => "L'expiration doit être comprise entre 0 et 180 min"
                ]),
            ]);

        if ($form->isSubmitted() && $form->isValid()) {
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
