<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Form\MemoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use DateTime;
use DateInterval;

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
        $memo->setExpirationDate($time = new \DateTime("now"));

        $form = $this->createForm(MemoType::class, $memo);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $minutes_to_add = $form->get('expirationDate')->getData();
            $time = new \DateTime("now");
            $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            
            $memo->setExpirationDate($time);
            
            $entityManager->persist($memo);
            $entityManager->flush();
            
            return $this->redirectToRoute('memo', ["id" => $memo->getId()]);
        } else {
            $this->addFlash('error', 'error');
        }
        $form->handleRequest($request);

        return $this->render('home/index.html.twig', [
            'memoForm' => $form->createView(),
        ]);
    }
}
