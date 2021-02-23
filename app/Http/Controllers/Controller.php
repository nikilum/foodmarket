<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    public function getEmailAndGroup()
    {
        if (!Session::has('user_email')) {
            $userEmail = 'guest';
            $userGroup = 'default';
        } else {
            $userEmail = Session::get('user_email');
            $userGroup = User::getGroupByEmail($userEmail);
        }
        return ['user_email' => $userEmail, 'user_group' => $userGroup];
    }

    public function endFunc()
    {
        echo json_encode(['status' => 'ok']);
    }
}
