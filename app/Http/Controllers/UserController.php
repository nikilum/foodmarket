<?php

namespace App\Http\Controllers;

use App\Mail\MailVerify;
use App\Models\BalanceHistory;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Verify;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function register(Request $request)
    {
        // Получение данных
        $userEmail = $request->input('user_email');
        $userPassword = $request->input('user_password');
        $userName = $request->has('user_name') ? $request->input('user_name') : null;
        $userAddress = $request->has('user_address') ? $request->input('user_address') : null;
        $userPhone = $request->has('user_phone') ? $request->input('user_phone') : null;

        // Проверки полученных данных
        if (!$request->has('user_email', 'user_password'))
            return false;
        if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL))
            return false;
        if (strlen(str_replace(" ", '', $userPassword)) < 8 ||
            strlen(str_replace(" ", '', $userPassword)) > 32)
            return false;
        $duplicates = User::where('user_email', $userEmail)->count();
        if ($duplicates !== 0) {
            echo json_encode(["status" => "email alerady exists"]);
            return false;
        }

        // Хеширование пароля
        $charsToRandomize = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $userSalt = substr(str_shuffle($charsToRandomize), 0, 16);
        $hashedPassword = hash('sha512', $userPassword . $userSalt);
        $userInfo = [
            'user_email' => $userEmail,
            'user_password' => $hashedPassword,
            'user_name' => $userName,
            'user_salt' => $userSalt,
            'user_address' => $userAddress,
            'user_phone' => $userPhone,
            'created_at' => now()
        ];

        // Создание и сохранение нового пользователя
        $user = new User($userInfo);
        $user->save();
        Session::put('user_email', $userEmail);

        // Создание кода верификации
        $userId = User::where('user_email', $userEmail)->value('user_id');
        $verifyCode = strtolower(substr(str_shuffle($charsToRandomize), 0, 16));
        $verifyInfo = [
            'user_id' => $userId,
            'verify_code' => $verifyCode,
            'created_at' => now(),
        ];
        $verify = new Verify($verifyInfo);
        $verify->save();

        //Отправка кода верификации на почту
        Mail::to($userEmail)->send(new MailVerify(['verify_code' => $verifyCode]));
        echo json_encode(['status' => 'ok']);
    }

    public function verifyMail(Request $request)
    {

        // Принятие обязательных данных - кода верификации и почты
        $inputtedCode = $request->input('verify_code');
        if ($request->has('user_email'))
            $userEmail = $request->input('user_email');
        else
            $userEmail = Session::get('user_email');

        // Получение строки кода и строки пользователя из БД
        $user = User::where('user_email', $userEmail)->first();
        $verify = Verify::where('user_id', $user->user_id)->first();

        // Проверка совпадения кодов
        if ($verify->verify_code !== $inputtedCode) {
            echo json_encode(['status' => 'verify failed']);
            return false;
        }

        // Сохранение времени верификации пользователя
        $user->user_email_verified_at = now();
        $user->save();

        // Удаление кода верификации из БД за его ненадобностью
        $verify->delete();

        // Добавление почты пользователя в сессию, если он ещё не был зарегистрирован
        if (!Session::has('user_email'))
            Session::put('user_email', $userEmail);
        Session::put('verified', true);

        Controller::endFunc();
    }

    public function repeatVerifyCode(Request $request)
    {
        if ($request->has('user_email'))
            $userEmail = $request->input('user_email');
        else
            $userEmail = Session::get('user_email');

        // Получение строки кода и строки пользователя из БД
        $currentUser = User::where('user_email', $userEmail);
        $currentVerify = Verify::where('user_id', $currentUser->value('user_id'))->first();

        // Создание и сохранение нового кода верификации
        $charsToRandomize = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $verifyCode = substr(str_shuffle($charsToRandomize), 0, 16);
        $currentVerify->verify_code = $verifyCode;
        $currentVerify->save();

        // Отправка письма с подтверждением
        Mail::to($userEmail)->send(new MailVerify(['verify_code' => $verifyCode]));

        Controller::endFunc();
    }

    public function login(Request $request)
    {
        // Получение данных о пользователе из формы
        $userEmail = $request->get('user_email');
        $inputtedPassword = $request->get('user_password');

        // Получение соли для пароля
        $currentUser = User::where('user_email', $userEmail);
        $userSalt = $currentUser->value('user_salt');
        $userPassword = $currentUser->value('user_password');
        $saltedPassword = $inputtedPassword . $userSalt;
        // Хеширование пароля
        $hashedPassword = hash('sha512', $saltedPassword);
        // Проверка пароля

        if ($userPassword !== $hashedPassword)
            return false;

        Session::put('user_email', $userEmail);
        if ($currentUser->value('user_email_verified_at') !== null)
            Session::put('verified', true);

        Controller::endFunc();
    }
}
