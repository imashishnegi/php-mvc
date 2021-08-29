<?php
namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Users;

class HomeController extends Controller {

    public function index()
    {
        // $users = Users::fields('id,name')->find(1);
        // print_r($users);die;
        View::render('Home/index');
    }
}