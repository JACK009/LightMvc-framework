<?php

namespace App\Controllers;

use App\LightMvc\Core\Controller;
use App\Models\User;

class HomeController extends Controller
{
    public function indexAction() {
        $user = new User();
        $user->name = 'test';

        $this->view('home/index', ['user' => $user]);
    }
}