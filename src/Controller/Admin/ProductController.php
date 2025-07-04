<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Form\SelectFormType;
use App\Form\SearchFulltextType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SubCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
* @Route("/admin/product", name="app_admin_product_")
 */
class ProductController extends AbstractController
{
    private $categoryRepository;
    private $subcategoryRepository;
    private $productRepository;

    public function __construct(CategoryRepository $categoryRepository, SubCategoryRepository $subcategoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->subcategoryRepository = $subcategoryRepository;
        $this->productRepository = $productRepository;
    }
    
    /**
     * @Route("/", name="list")
     */
    public function ProductList(Request $request): Response
    {
        $categories =  $this->categoryRepository->findAll();
        $subcategories =  $this->subcategoryRepository->findAll();

        $product = $this->productRepository->findAll();
        $formFullText = $this->createForm(SearchFulltextType::class); // récupère le form du input search
        $search = $formFullText->handleRequest($request);

        if($formFullText->isSubmitted() && $formFullText->isValid()) {
            // on recherche les produits correspondant au mots clés
            $product = $this->productRepository->searchFulltext($search->get('key')->getData());
        }

        $formSelect = $this->createForm(SelectFormType::class); // récupère le form du select catégorie et sous-catégorie
        $formSelect->handleRequest($request);

        if($formSelect->isSubmitted() && $formSelect->isValid()) {

            $product = $this->productRepository->findby(['subCategory' => $formSelect->getData()->getsubCategory()->getId()], [], null, null);   
        }

        return $this->render('admin/product/list_product.html.twig', [
            'Listproduct' => $product,
            'categories' => $this->categoryRepository->findAll(),
            'Fulltextform' => $formFullText->createView(),
            'categories' => $categories,
            'subCategories' => $subcategories,
            'formSelect' => $formSelect->createView()
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addProduct(Request $request, EntityManagerInterface $manager)
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('images')->getData(); // On récupère les données de l'image téléchargé
            // fileName = md5(uniqid()).'.'.$file->guessExtension() // pour sécuriser le nom du fichier 
            $fileName = $file->getClientOriginalName(); // pour récupérer le nom original de l'image
            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('images_directory'), // le dossier d'enregistrement
                    $fileName // le fichier à stocker ('nom')
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $product->setImage($fileName);
            $manager->persist($product);
            $manager->flush(); 

            $this->addFlash('add_success', 'Nouveau produit ajouté !');
            return $this->redirectToRoute('app_admin_product_list');
        }

        return $this->render('admin/product/add.html.twig', [
            'form' => $form->createView(),
            'categories' => $this->categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function editProduct(Product $product, ProductRepository $productRepository, Request $request, EntityManagerInterface $manager)
    {
        $products = $productRepository->findAll();
        $form = $this->createForm(ProductType::class, $product, [
            'image_file_no_required' => true // on récupère l'option configuré dans ProductType pour rendre la modification d'image non obligatoire
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('image_file')->getData(); // On récupère les données de l'image téléchargé
            // fileName = md5(uniqid()).'.'.$file->guessExtension() // pour sécuriser le nom du fichier 
            $fileName = $file->getClientOriginalName(); // pour récupérer le nom original de l'image
            // Move the file to the directory where fileName are stored
            try {
                $file->move(
                    $this->getParameter('images_directory'), // le dossier d'enregistrement
                    $fileName // le fichier à stocker ('nom')
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            $product->setImage($fileName);
            $manager->persist($product);
            $manager->flush(); 

            $this->addFlash('edit_success', 'Produit modifié !');
            return $this->redirectToRoute('app_admin_product_details', ['id' => $product->getId()]); // on passe en paramètre l'id du produit 
        }

        return $this->render('admin/product/edit.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'categories' => $this->categoryRepository->findAll()

        ]);
    }

     /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteProduct(Product $product, EntityManagerInterface $manager): Response 
    {        
            $manager->remove($product); 
            $manager->flush();
        
        return $this->redirectToRoute('app_admin_product_list');
    }

     /**
     * @Route("/detail/{id}", name="details")
     */
    public function detailsProduct(): Response 
    {           
        $product = $this->productRepository->findAll();
        $categories = $this->categoryRepository->findAll();


        return $this->render('admin/product/details.html.twig', compact('product', 'categories'));
    }
}
    
