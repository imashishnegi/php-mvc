<?php
namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Users;

class UsersController extends Controller {

    public function login()
    {
        View::render('User/login');
    }

    public function signup()
    {
        View::render('User/signup');
    }

    public function register()
    {
        $request = $this->postParams();
        if (!empty($request['email']) && !empty($request['name']) && !empty($request['password'])) {
            Users::save($request);
        }
        $this->redirect('login');
    }
}