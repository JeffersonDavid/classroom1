<?php
require 'Conexion.php';

class AppController
{
    public App $model;

    public function __construct(App $model)
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

            case 'user-delete':
                $this->handleUserDeletion();
                break;

            case 'product-delete':
                $this->handleProductDeletion();
                break;

            case 'show-add':
                    $this->showAddToDatabaseFromModel();
                    break;

            case 'model-add':
                    $this->addToDatabaseFromModel();
                    break;
            case 'user-default':
                    $this->showView('dashboard', ['productos' => $this->model->getProducts() ]);
                    break;

            case 'buy-product':
                    $this->showView('dashboard', ['productos' => $this->model->getProducts() ]);
                    break;
            case 'user-history':
                    
                    $user_data = $this->userParams();
                   
                    $this->showView('user_history', ['data' => $this->model->productsByUser( $user_data['user_id']) ]);
                    break;
            
            default:
                $this->showView('login');
                break;
        }
    }

//cliente@cliente.com

    private function addToDatabaseFromModel(){

        $type = $_REQUEST['model_type'] ?? '';
        $user_params = $this->userParams();
        
        switch ($type) {
            case 'users':
                $existUser = $this->model->userByEmail($user_params['email']);
                if (!$existUser) {
                    $this->model->createUser( $user_params['name'], $user_params['email'], $user_params['password'],$user_params['role']);
                    $this->showView('add', ['type' => $type , 'message' => 'Usuario creado correctamente']);
                    exit;
                }
                    $this->showView('add', ['type' => $type , 'message'=>'El email ya esta registrado']);
            break;
            case 'products':
                $params = $this->productParams();
                $this->model->createProduct($params);
                $this->showView('add', ['type' => $type , 'message'=>'Producto creado correctamente']);
            break;
            default:
            $this->showView('404');
            break;
        }
    }

    private function showAddToDatabaseFromModel()
    {
        $type = $_REQUEST['model_type'] ?? '';
        $this->showView('add', ['type' => $type ]);
    }

    private function handleProductDeletion()
    {
        $params = $this->productParams();
        $this->model->deleteProductByID($params['id']);
        $this->showView('adminProducts', ['productos' =>  $this->model->getProducts()]);

    }

    private function handleUserDeletion()
    {
        $user_params = $this->userParams();
        $this->model->deleteUserByID($user_params['user_id']);
        $this->showView('admin', ['users' => $this->model->users_all()]);

    }


    private function handleUserEdition()
    {
        $user_params = $this->userParams();
        $this->model->updateUser($user_params);
        $user = $this->model->userByID($user_params['user_id']);
        $this->showView('users_crud', ['user_data_' => $user, 'message' => 'Datos actualizados correctamente']);
    }

    private function handleUserShowEdition()
    {
        $user_params = $this->userParams();
        $user = $this->model->userByID($user_params['user_id']);
        $this->showView('users_crud', ['user_data_' => $user]);
    }

    private function handleEditProduct()
    {
        $params = $this->productParams();
        $this->model->updateProduct($params);
        $this->handleShowEditProduct(['message' => 'Datos actualizados correctamente']);
    }

    private function handleUserCreation()
    {
        $user_params = $this->userParams();
        $existUser = $this->model->userByEmail($user_params['email']);

        if (!$existUser) {
            $this->model->createUser($user_params['name'], $user_params['email'], $user_params['password']);
            $this->showView('login', ['message' => 'Usuario creado correctamente']);
        } else {
            $this->showView('register', ['errmessage' => 'El correo electrónico ya existe']);
        }
    }

    private function handleAuthentication()
    {
        $user_params = $this->userParams();
        $existUser = $this->model->userByEmail($user_params['email']);

        if (!$existUser || !$this->checkUserPass(base64_encode($user_params['password']), $existUser['password'])) {

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
            header('Location: index.php?page=user-default&user_id=' . $user['id']);
            exit;

        } else {

            header('Location: index.php?page=admin&user_id=' . $user['id'] . '&password=' . $user['password']);
        }

        exit;
    }

    private function handleAdminAuthentication()
    {
        try {
            $this->defineAdminView();
        } catch (\Throwable $th) {
            $this->showView('login', ['errmessage' => 'Correo o contraseña incorrecta']);
        }
    }

    private function handleShowEditProduct($data_view = false)
    {
        $product_params = $this->productParams();
        $product_id = $product_params['id'];

        try {
            $product_data = $this->model->productByID((int)$product_id);
            $this->showView('product_crud', ['product_data' => $product_data, 'data_view' => $data_view]);
        } catch (\Throwable $th) {
            $this->showView('404');
        }
    }

    private function defineAdminView()
    {
        $adminPage = $_GET['adminPage'] ?? 'default';

        if ($adminPage === 'products') {
            $this->showView('adminProducts', ['productos' =>  $this->model->getProducts()]);
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
?>
