<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route("/show/{name}",methods:['GET'], name:"show")]
        public function show(string $name, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
        {
            $category = $categoryRepository->findOneBy(['name' => $name]);
            if(!$category){
                throw $this->createNotFoundException(
                    'No category founded'
                );
            }
        $programs = $programRepository->findBy(['category' => $category], ['id' => 'DESC'], 3, 0);
            
            return $this->render('category/show.html.twig', ['category' => $category, 'programs' => $programs]);
        }
}
// $cat = $categoryRepository->findOneBy(['name' => $name]);
// $programs = $programRepository->findBy(['category' => $cat], ['id' => 'DESC'], 3, 0);
// return $this->render('category/show.html.twig', ['category' => $programs]);