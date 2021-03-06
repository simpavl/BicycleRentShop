<?php

namespace Shop\Controller;

use Shop\Entity\Order;
use Shop\Entity\OrderProducts;
use Shop\Entity\OrderProductsLinker;
use Shop\Entity\ProductImage;
use Shop\Entity\ProductImageLinker;
use Shop\Form\CategoryForm;
use Shop\Form\EditOrderForm;
use Shop\Form\OrderProductsForm;
use Shop\Form\ProductCategoryFirstForm;
use Shop\Form\ProductCategorySecondForm;
use Shop\Form\ProductImageForm;
use Shop\Form\SubCategoryForm;
use Shop\Form\UserForm;
use Shop\Form\ProductForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Shop\Entity\Category;
use Shop\Entity\Subcategory;
use Shop\Entity\User;
use Shop\Entity\Product;
use Shop\Entity\Orders;

class AdminController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Constructor is used for injecting dependencies into the controller.
     */

    /**
     * AdminController constructor.
     * @var \Shop\Service\CategoryManager
     */

    private $categoryManager;

    /**
     * AdminController constructor.
     * @var \Shop\Service\UserManager
     */

    private $userManager;

    /**
     * AdminController constructor.
     * @var \Shop\Service\ProductManager
     */

    private $productManager;

    /**
     * AdminController constructor.
     * @var \Shop\Service\OrderManager
     */

    private $orderManager;

    public function __construct($entityManager, $categoryManager, $userManager,$productManager, $orderManager)
    {
        $this->entityManager = $entityManager;
        $this->categoryManager = $categoryManager;
        $this->userManager = $userManager;
        $this->productManager = $productManager;
        $this->orderManager = $orderManager;
    }

    public function indexAction()
    {
        $categories = $this->entityManager->getRepository(Category::class)->findBy([], ['id'=>'ASC']);
        $subcategories = $this->entityManager->getRepository(Subcategory::class)->findBy([], ['id'=>'ASC']);
        $users = $this->entityManager->getRepository(User::class)->findBy([], ['id' => 'ASC']);
        $products = $this->entityManager->getRepository(Product::class)->findBy([], ['id' => 'ASC']);
        $orders = $this->entityManager->getRepository(Orders::class)->findBy([], ['id' => 'ASC']);
        $orderprods = $this->entityManager->getRepository(OrderProducts::class)->findBy([], ['id' => 'ASC']);
        if ($this->identity()!=null) {
            $userEmail = $this->identity();
        } else{
            $userEmail = null;
        }
        return new ViewModel([
            'categories' => $categories,
            'subcategories' => $subcategories,
            'products' => $products,
            'categoryManager' => $this->categoryManager,
            'users' => $users,
            'userEmail' => $userEmail,
            'orders' => $orders,
            'orderprods' => $orderprods,
        ]);
    }

    public function categoriesAction()
    {
        $categories = $this->entityManager->getRepository(Category::class)->findBy([], ['id'=>'ASC']);
        return new ViewModel([
            'categories' => $categories,
        ]);
    }
    public function subcategoriesAction()
    {
        $subcategories = $this->entityManager->getRepository(Subcategory::class)->findBy([], ['id'=>'ASC']);
        return new ViewModel([
            'subcategories' => $subcategories,
        ]);
    }
    public function usersAction()
    {
        $users = $this->entityManager->getRepository(User::class)->findBy([], ['id' => 'ASC']);
        return new ViewModel([
            'users' => $users,
        ]);
    }
    public function productsAction()
    {
        $products = $this->entityManager->getRepository(Product::class)->findBy([], ['id' => 'ASC']);
        return new ViewModel([
            'products' => $products,
        ]);
    }
    public function ordersAction()
    {
        $orders = $this->entityManager->getRepository(Orders::class)->findBy([], ['id' => 'ASC']);
        return new ViewModel([
            'orders' => $orders,
        ]);
    }
    public function addCategoryAction()
    {
        $form = new CategoryForm();
        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->categoryManager->addNewCategory($data);

                return $this->redirect()->toRoute('admin',['action'=>'categories']);
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }
    public function editCategoryAction()
    {
        $form = new CategoryForm();
        $catid = $this->params()->fromRoute('id', -1);

        $category = $this->entityManager->getRepository(Category::class)->findOneById($catid);
        if($category == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->categoryManager->updateCategory($category,$data);

                return $this->redirect()->toRoute('admin', ['action' => 'categories']);
            }
        } else {
            $data = [
                'name' => $category->getName()
            ];
            $form->setData($data);
        }
        return new ViewModel([
            'form' => $form,
            'category' => $category
        ]);
    }
    public function deleteCategoryAction()
    {
        $catid = $this->params()->fromRoute('id', -1);
        $category = $this->entityManager->getRepository(Category::class)->findOneById($catid);
        if($category == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->categoryManager->removeCategory($category);
        return $this->redirect()->toRoute('admin',['action'=>'categories']);
    }
    public function addSubCategoryAction()
    {
        $form = new SubCategoryForm($this->entityManager);

        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->categoryManager->addNewSubCategory($data);

                return $this->redirect()->toRoute('admin');
            }
        }
        return new ViewModel([
            'form' => $form
        ]);
    }
    public function editSubCategoryAction()
    {
        $form = new SubCategoryForm($this->entityManager);

        $catid = $this->params()->fromRoute('id', -1);

        $category = $this->entityManager->getRepository(Subcategory::class)->findOneById($catid);
        if($category == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if($this->getRequest()->isPost()) {

            $data = $this->params()->fromPost();

            $form->setData($data);
            if ($form->isValid()) {
                $data = $form->getData();
                $this->categoryManager->updateSubCategory($category,$data);

                return $this->redirect()->toRoute('admin');
            }
        } else {
            $data = [
                'name' => $category->getName(),
                'category' => $category->getCategory(),
            ];
            $form->setData($data);
        }
        return new ViewModel([
            'form' => $form,
            'category' => $category
        ]);
    }
    public function deleteSubCategoryAction()
    {
        $catid = $this->params()->fromRoute('id', -1);
        $category = $this->entityManager->getRepository(Subcategory::class)->findOneById($catid);
        if($category == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->categoryManager->removeSubCategory($category);
        return $this->redirect()->toRoute('admin');
    }
    public function usersListAction()
    {
        $users = $this->entityManager->getRepository(User::class)->findBy([], ['id' => 'ASC']);
        return new ViewModel([
            'users' => $users
        ]);
    }

    public function addUserAction()
    {
        $form = new UserForm('create', $this->entityManager);
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $user = $this->userManager->addUser($data);
                return $this->redirect()->toRoute('admin',
                    ['action'=>'view-user', 'id'=>$user->getId()]);
            }
        }

        return new ViewModel([
            'form' => $form
        ]);
    }
    public function viewUserAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Find a user with such ID.
        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return new ViewModel([
            'user' => $user
        ]);
    }
    public function editUserAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $user = $this->entityManager->getRepository(User::class)
            ->find($id);

        if ($user == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new UserForm('update', $this->entityManager, $user);

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $this->userManager->updateUser($user, $data);
                return $this->redirect()->toRoute('admin',
                    ['action'=>'view-user', 'id'=>$user->getId()]);
            }
        } else {
            $form->setData(array(
                'first_name'=>$user->getFirstName(),
                'last_name'=>$user->getSurName(),
                'email'=>$user->getEmail(),
                'status'=>$user->getUseractive(),
                'gender'=>$user->getGender(),
            ));
        }

        return new ViewModel(array(
            'user' => $user,
            'form' => $form
        ));
    }

    public function addProductAction()
    {
        $tempFile = null;
        $form = new ProductForm($this->entityManager);
        $prg = $this->fileprg($form);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg; // Return PRG redirect response
        }
        // Check if user has submitted the form
        if (is_array($prg)) {
            // Validate form
            if ($form->isValid()) {

                // Get filtered and validated data
                $data = $form->getData();
                // Add user
                $user = $this->productManager->addNewProduct($data);
                // Redirect to "view" page
                return $this->redirect()->toRoute('admin');
            }
            // Get the temporary file information to show the user in the view
            $fileErrors = $form->get('image-file')->getMessages();

            if (empty($fileErrors)) {
                $tempFile = $form->get('image-file')->getValue();
            }

        }

        return new ViewModel([
            'form' => $form,
            'tempFile' => $tempFile,
        ]);
    }

    public function editProductAction()
    {
        $form = new ProductForm($this->entityManager);
        $tempFile = null;
        $prodid = $this->params()->fromRoute('id', -1);

        $product = $this->entityManager->getRepository(Product::class)->findOneById($prodid);
        if($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $prg = $this->fileprg($form);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg; // Return PRG redirect response
        }
        // Check if user has submitted the form
        if (is_array($prg)) {
            // Validate form
            if ($form->isValid()) {
                $data = $form->getData();
                $this->productManager->updateProduct($product,$data);

                return $this->redirect()->toRoute('admin',['action'=>'products']);
            }
            // Get the temporary file information to show the user in the view
            $fileErrors = $form->get('image-file')->getMessages();

            if (empty($fileErrors)) {
                $tempFile = $form->get('image-file')->getValue();
            }
        } else {
            $data = [
                'name' => $product->getName(),
                'price' => $product->getPrice(),
                'description' => $product->getDescription(),
                'quantity' => $product->getQuantity(),
                'category' => $product->getSubCategory(),
            ];
            $form->setData($data);
        }
        return new ViewModel([
            'form' => $form,
            'product' => $product,
            'tempFile' => $tempFile,
        ]);
    }
    public function addProductImagesAction()
    {
        $form = new ProductImageForm();
        $tempFile = null;
        $prodid = $this->params()->fromRoute('id', -1);

        $product = $this->entityManager->getRepository(Product::class)->findOneById($prodid);
        if($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $prg = $this->fileprg($form);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg; // Return PRG redirect response
        }
        // Check if user has submitted the form
        if (is_array($prg)) {
            if ($form->isValid()) {
                $data = $form->getData();

                $user = $this->productManager->addNewProductImages($data,$prodid);
                return $this->redirect()->toRoute('admin');
            }
            $fileErrors = $form->get('image-file')->getMessages();

            if (empty($fileErrors)) {
                $tempFile = $form->get('image-file')->getValue();
            }
        }
        return new ViewModel([
            'form' => $form,
            'product' => $product,
            'tempfile' => $tempFile,
        ]);
    }
    public function productImagesAction()
    {
        $form = new ProductForm($this->entityManager);

        $prodid = $this->params()->fromRoute('id', -1);
        $images = null;
        $product = $this->entityManager->getRepository(Product::class)->findOneById($prodid);
        if($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $images = $product->getImages();
        return new ViewModel([
            'form' => $form,
            'images' => $images,
            'prodid' => $prodid,
        ]);
    }
    public function editProdimgAction()
    {
        $form = new ProductForm($this->entityManager);
        $tempFile = null;
        $prodid = $this->params()->fromRoute('id', -1);

        $prodimg = $this->entityManager->getRepository(ProductImage::class)->findOneById($prodid);
        if($prodimg == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $prg = $this->fileprg($form);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg; // Return PRG redirect response
        }
        // Check if user has submitted the form
        if (is_array($prg)) {
            if ($form->isValid()) {
                $data = $form->getData();

                $user = $this->productManager->replaceProductImage($data,$prodimg);
                return $this->redirect()->toRoute('products');
            }
            $fileErrors = $form->get('image-file')->getMessages();

            if (empty($fileErrors)) {
                $tempFile = $form->get('image-file')->getValue();
            }
        }
        return new ViewModel([
            'form' => $form,
            'prodimg' => $prodimg,
            'tempfile' => $tempFile,
        ]);
    }
    public function removeProdimgAction()
    {
        $imgid = $this->params()->fromRoute('id', -1);
        $prodimg = $this->entityManager->getRepository(ProductImage::class)->findOneById($imgid);
        if($prodimg == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $prodid = $prodimg->getProduct()->getId();
        $linker = $this->entityManager->getRepository(ProductImageLinker::class)->findOneBy(['productid' => $prodid,'imageid' => $imgid] );
        $this->productManager->removeProdimg($prodimg,$linker);
        return $this->redirect()->toRoute('admin');
    }
    public function deleteProductAction()
    {
        $prodid = $this->params()->fromRoute('id', -1);
        $product = $this->entityManager->getRepository(Product::class)->findOneById($prodid);
        if($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->categoryManager->removeSubCategory($product);
        return $this->redirect()->toRoute('admin');
    }

    public function editOrderAction()
    {
        $id = (int)$this->params()->fromRoute('id', -1);
        if ($id<1) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $order = $this->entityManager->getRepository(Orders::class)
            ->find($id);

        if ($order == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $form = new EditOrderForm($this->entityManager);
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $this->orderManager->updateOrder($order,$data);
                return $this->redirect()->toRoute('admin',
                    ['action'=>'orders']);
            }
        } else {
            $form->setData(array(
                'email'=>$order->getUser()->getEmail(),
                'costs'=>$order->getOrdercost(),
                'status'=>$order->getStatus(),
            ));
        }

        return new ViewModel(array(
            'order' => $order,
            'form' => $form
        ));
    }
    public function deleteOrderAction()
    {
        $orderid = $this->params()->fromRoute('id', -1);
        $linker = $this->entityManager->getRepository(OrderProductsLinker::class)->findBy(['orderid'=>$orderid],['orderid'=>'ASC']);

        $order = $this->entityManager->getRepository(Orders::class)->findOneById($orderid);
        if($order == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->orderManager->removeOrder($order,$linker);
        return $this->redirect()->toRoute('admin',['action'=>'orders']);
    }
    public function orderProductsAction()
    {
        $orderid = $this->params()->fromRoute('id', -1);
        $products = null;
        $order = $this->entityManager->getRepository(Orders::class)->findOneById($orderid);
        if($orderid == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $products = $order->getProducts();
        return new ViewModel([
            'products' => $products,
            'orderid' => $orderid,
        ]);
    }
    public function editOrderProdAction()
    {
        $form = new OrderProductsForm($this->entityManager);
        $prodid = $this->params()->fromRoute('id', -1);

        $product = $this->entityManager->getRepository(OrderProducts::class)->findOneById($prodid);
        if($product == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()) {
                $data = $form->getData();
                $this->orderManager->updateOrderProd($product,$data);
                return $this->redirect()->toRoute('admin',
                    ['action'=>'orders']);
            }
        } else {
            $form->setData(array(
                'product'=>$product,
                'quantity'=>$product->getQuantity(),
                'status'=>$product->getStatus(),
                'start'=>$product->getStartdate(),
                'end'=>$product->getEnddate(),
            ));
        }
        return new ViewModel([
            'form' => $form,
            'product' => $product,
        ]);
    }
    public function deleteOrderProdAction()
    {
        $prodid = $this->params()->fromRoute('id', -1);
        $linker = $this->entityManager->getRepository(OrderProductsLinker::class)->findOneBy(['productid'=>$prodid],['productid'=>'ASC']);
        $prod = $this->entityManager->getRepository(OrderProducts::class)->findOneById($prodid);
        if($prod == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }
        $this->orderManager->removeOrderProd($prod,$linker);
        return $this->redirect()->toRoute('admin',['action'=>'orders']);
    }
}