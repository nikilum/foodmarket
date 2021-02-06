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
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        //Проверка на то, авторизован ли пользователь
        $userInfo = $this->getEmailAndGroup();
        return view('welcome', [
                'user_email' => $userInfo['user_email'],
                'user_group' => $userInfo['user_group']
        ]);
    }

    public function refill()
    {
        /*
         * Пополнение счёта на кошельке пользователя
         * Минимальная сумма пополнения - 1 рубль
         **/
    }

    public function ordering()
    {
        /*
         * Создание нового заказа/просмотр уже созданных заказов
         * Ограничение запросов на создание новых заказов по умолчанию - 5 в час
         * На изменение заказа даётся не более часа
         **/
    }

    // Управление панелями администраторов

    public function admin() //TODO перенести панели в отдельный контроллер, в конструкт добавить $userInfo
    {
        //Панель администратора сайта, доступ к созданию/редактированию товаров
        $userInfo = $this->getEmailAndGroup();
        if ($this->accessCheck('admin', $userInfo['user_group']) === true)
            return view('panels.admin', [
                'user_email' => $userInfo['user_email'],
                'user_group' => $userInfo['user_group']
            ]);
        abort(403);
    }

    public function manager()
    {
        //Панель менеджера сайта, доступ к заказам пользователей
        $userInfo = $this->getEmailAndGroup();
        if ($this->accessCheck('manager', $userInfo['user_group']))
            return view('panels.manager', [
                'user_email' => $userInfo['user_email'],
                'user_group' => $userInfo['user_group']
            ]);
        abort(403);
    }

    public function global()
    {
        //Панель глобального администратора сайта, доступ к редактированию администраторов и ко всему остальному
        $userInfo = $this->getEmailAndGroup();
        if ($this->accessCheck('global', $userInfo['user_group']))
            return view('panels.global', [
                'user_email' => $userInfo['user_email'],
                'user_group' => $userInfo['user_group']
            ]);
        abort(403);
    }

    // Функции для корректной загрузки страниц

    public function getEmailAndGroup()
    {
        //Если пользователь не авторизован, то присваиваются значения по умолчанию - почта guest и default группа
        if (!Session::has('user_email')) {
            $userEmail = 'guest';
            $userGroup = 'default';
        } else {
            //Если пользователь авторизован, получается его почта и группа
            $userEmail = Session::get('user_email');
            $userGroup = User::getGroupByEmail($userEmail);
        }
        return ['user_email' => $userEmail, 'user_group' => $userGroup];
    }

    public function accessCheck($groupName, $userGroup): bool
    {
        //Проверка на наличие группы, требующейся для доступа к панели
        if ($userGroup === 'global' || $userGroup === $groupName)
            return true;
        return false;
    }

    public function getProductById($id) {
        $product = Product::where('product_id', $id)->first();
        echo json_encode([
            'product_name' => $product->product_name,
            'product_description' => $product->product_description,
            'product_image_name' => $product->product_image_name
        ]);
    }
    public function getUserById($id) {
        $user = User::where('user_id', $id)->first();
        echo json_encode([
            'user_email' => $user->user_email,
            'user_group' => $user->user_group,
            'user_address' => $user->user_address,
            'user_phone' => $user->user_phone
        ]);
    }
}
