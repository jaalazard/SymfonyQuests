<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Form\CategoryType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
           'categories' => $categories,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $categoryRepository->save($category, true);
            return $this->redirectToRoute('category_index');
    }
        return $this->render('category/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository):Response
{
    $categories = $categoryRepository->findBy(['name' => $categoryName]);
     if (!$categories) {
        throw $this->createNotFoundException(
            'No category with name : '.$categoryName.' found in category\'s table.'
        );
    }

    $programs = $programRepository->findBy(
        ['category' => $categories],
        ['id' => 'DESC']
    );
    return $this->render('category/show.html.twig', [
        'categories' => $categories,
        'programs' => $programs,
    ]);

    

}
}