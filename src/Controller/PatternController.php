<?php

namespace App\Controller;

use App\Entity\Pattern;
use App\Form\PatternType;
use App\Repository\PatternRepository;
use App\Services\MessageService ;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/patterns')]
class PatternController extends AbstractController
{
    public function __construct(
        private PatternRepository $patternRepository,
        private EntityManagerInterface $em
    ) {
    }

    /**
     * Retourne tous les patrons
     *
     * @return Response
     */
    #[Route('/', 'app_patterns', methods:['GET'])]
    public function getPatterns(): Response
    {
        return $this->render(
            'pattern/displayPatterns.html.twig',
            ['patterns' => $this->patternRepository->findAll()]
        );
    }

    /**
     * Retourne le détail d'un patron
     *
     * @return Response
     */
    #[Route('/detail/{id}', 'app_pattern_detail', methods:['GET'])]
    public function getPatternDetail(Pattern $pattern): Response
    {
        return $this->render(
            'pattern/displayPatternDetail.html.twig',
            ['pattern' => $pattern]
        );
    }

    #[Route('/new', name:'app_pattern_new', methods: ['GET', 'POST'])]
    public function addPattern(Request $request): Response
    {

        $pattern = new Pattern();


        $form = $this->createForm(PatternType::class, $pattern);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $pattern = $form->getData();
            $this->em->persist($pattern);
            $this->em->flush();
            return $this->redirectToRoute('app_patterns');
        }

        return $this->render('pattern/new.html.twig', ['patternForm' => $form]);
    }

    #[Route('/edit/{id}', name:'app_pattern_edit', methods: ['GET', 'POST'])]
    public function editPattern(Request $request, Pattern $pattern): Response
    {

        $form = $this->createForm(PatternType::class, $pattern);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $pattern = $form->getData();
            $this->em->persist($pattern);
            $this->em->flush();
            return $this->redirectToRoute('app_patterns');
        }

        return $this->render('pattern/edit.html.twig', ['patternForm' => $form]);
    }

    #[Route('/delete/{id}', 'app_pattern_delete'),]
    public function deletePattern(Pattern $pattern): Response
    {
        $this->patternRepository->remove(($pattern));
        return $this->redirectToRoute('app_patterns');

    }

    #[Route('/message-service', name:'app_patterns_message')]
    public function messageServicePattern(MessageService $messageService): Response
    {
        return $this->render('services/messages.html.twig', ['majuscule' => $messageService->displayMessage()]);
    }
}
