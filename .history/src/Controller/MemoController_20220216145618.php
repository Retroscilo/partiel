<?php

namespace App\Controller;

use App\Entity\Memo;
use App\Repository\MemoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class MemoController extends AbstractController
{
    private $memoRepository;

    public function __construct(MemoRepository $memoRepository)
    {
        $this->memoRepository = $memoRepository;
    }

    /**
     * @Route("/memo/{id}", name="memo")
     */
    public function index($id): Response
    {
        $memo = $this->memoRepository->find($id);

        if(new DateTime() > $memo->getExpirationDate()) {
            
        }

        return $this->render('memo/index.html.twig', [
            'controller_name' => 'MemoController',
            "memo" => $memo
        ]);
    }
}
