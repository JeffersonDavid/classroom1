<?php

require 'Conexion.php';

class AppController
{
    public App $model;

    public function __construct( App $model )
    {
        $this->model = $model;
    }

    public function handleRequest()
    {
        $action = $_GET['page'] ?? 'default';

        switch ($action) {
            case 'register':
                $this->showView('register');
                break;

            case 'create/user':
                $this->handleUserCreation();
                break;

            case 'authenticate':
                $this->handleAuthentication();
                break;

            case 'admin':
                $this->handleAdminAuthentication();
                break;

            case 'show-edit-product':
                $this->handleShowEditProduct();
                break;
            
            case 'edit-product':
                $this->handleEditProduct();
                break;
            case 'show-user-edit':
                 $this->handleUserShowEdition();
                break;  
            case 'user-edit':
                $this->handleUserEdition();
                break;  
            default:
                $this->showView('login');
                break;
        }
    }


    private function handleUserEdition() {

        $user_params = $this->userParams();
        $this->model->updateUser($user_params);
        $user = $this->model->userByID($user_params['user_id']);
        $this->showView('users_crud', [ 'user_data_'=> $user , 'message'=> 'Datos actualizados correctamente']);
    }

    private function handleUserShowEdition() {

        $user_params = $this->userParams();
        $user = $this->model->userByID($user_params['user_id']);
        $this->showView('users_crud', [ 'user_data_'=> $user ]);
    }


    private function handleEditProduct(){

        $params = $this->productParams();
         $this->model->updateProduct($params);
        $this->handleShowEditProduct(['message'=>'Datos actualizados correctamente']);
    }

    private function handleUserCreation()
    {
        $userParams = $this->userParams();
        $existUser = $this->model->userByEmail($userParams['email']);

        if (!$existUser) {
            $this->model->createUser($userParams['name'], $userParams['email'], $userParams['password']);
            $this->showView('login', ['message' => 'Usuario creado correctamente']);
        } else {
            $this->showView('register', ['errmessage' => 'El correo electrónico ya existe']);
        }
    }

    private function handleAuthentication()
    {
        $userParams = $this->userParams();
        $existUser = $this->model->userByEmail($userParams['email']);

        if (!$existUser || !$this->checkUserPass(base64_encode($userParams['password']), $existUser['password'])) {
            $this->showView('login', ['errmessage' => 'Correo o contraseña incorrecta']);
        } else {
            $this->handleSuccessfulAuthentication($existUser);
        }
    }

    private function handleSuccessfulAuthentication($user)
    {
        session_start();
        $_SESSION['userlog'] = $user;

        if ((int)$user['role'] === 1) {
            $_SESSION['productos'] = $this->model->getProducts();
            header('Location: Vista/dashboard.php');
        } else {
            header('Location: index.php?page=admin&user_id=' . $user['id'] . '&password=' . $user['password']);
        }

        exit;
    }

    private function handleAdminAuthentication()
    {
        $userParams = $this->userParams();

        try {
                $this->defineAdminView();
        } catch (\Throwable $th) {
            $this->showView('login', ['errmessage' => 'Correo o contraseña incorrecta']);
        }
    }

    private function handleShowEditProduct( $data_view = false )
    {
        $product_params = $this->productParams();
        $product_id = $product_params['id'];

        try {

            $product_data = $this->model->productByID((int)$product_id);
            
            $this->showView('product_crud', ['product_data' => $product_data, 'data_view' => $data_view ]);
        } catch (\Throwable $th) {
            $this->showView('404');
        }
    }

    private function defineAdminView()
    {
        $adminPage = $_GET['adminPage'] ?? 'default';

        if ($adminPage === 'products') {

            $_SESSION['productos'] = $this->model->getProducts();
            header('Location: Vista/adminProducts.php');
            
        } else {

           $this->showView('admin', ['users' => $this->model->users_all()]);
        }

        exit;
    }

    private function checkUserPass(string $hashedPassword, string $real_password): bool
    {
        return $hashedPassword === $real_password;
    }

    private function showView(string $viewName, array $data = [])
    {
        extract($data);
        include 'Vista/' . $viewName . '.php';
    }

    private function userParams(): array
    {
        return [
            'name' => $_REQUEST['name'] ?? '',
            'email' => $_REQUEST['email'] ?? '',
            'password' => $_REQUEST['password'] ?? '',
            'user_id' => $_REQUEST['user_id'] ?? '',
            'role' => $_REQUEST['role'] ?? ''
        ];
    }

    private function productParams(): array
    {
        return [
            'id' => $_REQUEST['product_id'] ?? '',
            'nombre' => $_REQUEST['product_name'] ?? '',
            'precio' => $_REQUEST['product_price'] ?? '',
            'descripcion' => $_REQUEST['product_desc'] ?? '',
        ];
    }
}