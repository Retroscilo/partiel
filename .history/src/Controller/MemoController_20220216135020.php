<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemoController extends AbstractController
{
    /**
     * @Route("/memo/{id}", name="memo")
     */
    public function index($id): Response
    {
        return $this->render('memo/index.html.twig', [
            'controller_name' => 'MemoController',
            "id" => $id
        ]);
    }
}
