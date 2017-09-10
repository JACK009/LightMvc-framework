<?php

namespace App\Controllers;

use App\Models\User;
use LightMvc\Core\Controller;

class HomeController extends Controller
{
    public function indexAction() {
        $user = new User();
        $user->name = 'test';

        $this->view('home/index', ['user' => $user]);
    }
}