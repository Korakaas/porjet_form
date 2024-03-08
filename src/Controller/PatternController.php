<?php

namespace App\Controller;

use App\Entity\Pattern;
use App\Form\PatternType;
use App\Repository\CategoryRepository;
use App\Repository\PatternRepository;
use App\Repository\YarnRepository;
use App\Services\MessageService ;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/patterns')]
class PatternController extends AbstractController
{
    public function __construct(
        private PatternRepository $patternRepository,
        private EntityManagerInterface $em,
        private CategoryRepository $categoryRepository,
        private YarnRepository $yarnRepository
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
            ['patterns' => $this->patternRepository->findAll(),
            'categories' => $this->categoryRepository->findAll(),
            'yarns' => $this->yarnRepository->findAll(),

            ]
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


    /**
     * Retourne tous les patrons en fonction de la catégorie
     *
     * @return Response
     */
    #[Route('/pattern-category', 'app_patterns_category')]
    public function getPatternsByCategory(Request $request): Response
    {

        $categoryId = $request->request->get('category_id');

        return $this->render(
            'pattern/displayPatternsByCategory.html.twig',
            ['patterns' => $this->patternRepository->findByCategory($categoryId),
            'categories' => $this->categoryRepository->findAll(),
            'yarns' => $this->yarnRepository->findAll(),
            ]
        );
    }



    /**
     * Retourne tous les patrons  en fonction de la laine sélectionnée
     *
     * @return Response
     */
    #[Route('/pattern-yarn', 'app_patterns_yarn')]
    public function getPatternsByYarn(Request $request): Response
    {
        $yarnId = $request->request->get('yarn_id');

        return $this->render(
            'pattern/displayPatternsByYarn.html.twig',
            ['patterns' => $this->patternRepository->findByYarn($yarnId),
            'categories' => $this->categoryRepository->findAll(),
            'yarns' => $this->yarnRepository->findAll(),

            ]
        );
    }

    /**
     * Retourne tous les patrons en fonction d'un mot clé
     *
     * @return Response
     */
    #[Route('/pattern-keyword', 'app_patterns_keyword')]
    public function getPatternsByKeyword(Request $request): Response
    {
        $keyword = $request->request->get('keyword');

        return $this->render(
            'pattern/displayPatternsByKeyword.html.twig',
            ['patterns' => $this->patternRepository->findByKeyword($keyword),
            'categories' => $this->categoryRepository->findAll(),
            'yarns' => $this->yarnRepository->findAll(),

            ]
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

    #[Route('/patterns-json', name:'app_patterns_json')]
    public function patternsJSON(SerializerInterface $serialiser ):JsonResponse{
        $patterns = $this->patternRepository->findAll();
        $pattern_to_json = $serialiser->serialize($patterns, 'json', ['groups' => 'patterns']);

        return new JsonResponse($pattern_to_json, Response::HTTP_OK, [], true);
    }

    #[Route('/patterns-api', name:'app_patterns_api')]
    public function patternsAPI( ):Response{
        return $this->render('pattern/displayPatternJson.html.twig');
    }
}
