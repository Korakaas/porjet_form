<?php

namespace App\Controller;

use App\Entity\Yarn;
use App\Repository\YarnRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/yarns')]
class YarnController extends AbstractController
{
    public function __construct(private YarnRepository $yarnRepository)
    {
    }

    /**
     * Retourne toutes les laines
     *
     * @return Response
     */
    #[Route('/', 'app_yarns', methods:['GET'])]
    public function getYarns(): Response
    {
        return $this->render(
            'yarn/displayYarns.html.twig',
            ['yarns' => $this->yarnRepository->findAll()]
        );
    }

    /**
     * Retourne le détail d'une laine
     *
     * @return Response
     */
    #[Route('/{id}', 'app_yarn_detail', methods:['GET'])]
    public function getYarnDetail(Yarn $yarn): Response
    {
        return $this->render(
            'yarn/displayYarnDetail.html.twig',
            ['yarn' => $yarn]
        );
    }



}