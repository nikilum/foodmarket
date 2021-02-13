<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PanelController extends Controller
{
    // Функции панели менеджера

    public function setOrderStatus()
    {
        // $status = 'not viewed';
        // $status = 'accepted';
        // $status = 'declined';
        // $status = 'done';
    }

    // Функции панели администратора

    public function createProduct(Request $request)
    {
        if (($request->has(['product_name', 'product_description', 'product_price'])
                && $request->hasFile('product_image')) === false)
            return false;

        if(!filter_var($request->input('product_price'), FILTER_VALIDATE_INT))
            return false;

        if (($request->file('product_image')->extension() === 'jpg'
                || $request->file('product_image')->extension() === 'jpeg'
                || $request->file('product_image')->extension() === 'png'
                || $request->file('product_image')->extension() === 'bmp') === false
        )
            return false;

        $productName = $request->input('product_name');
        $productDescription = $request->input('product_description');
        $productImage = $request->file('product_image');
        $productImagePath = Storage::putFile('public/products', $productImage, 'public');
        $imageName = preg_split('/\//', $productImagePath);
        $productData = array(
            'product_name' => $productName,
            'product_price' => $request->input('product_price'),
            'product_description' => $productDescription,
            'product_image_name' => end($imageName),
            'created_at' => now()
        );

        $product = new Product($productData);
        $product->save();

        echo json_encode(["status" => 'ok']);
    }

    public function updateProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');
        $productDescription = $request->input('product_description');
        if($request->file('product_image') !== null) {
            $productFile = $request->file('product_image');

            if (($productFile->extension() === 'jpg'
                    || $productFile->extension() === 'jpeg'
                    || $productFile->extension() === 'png'
                    || $productFile->extension() === 'bmp') === false
            )
                return false;
        }

        $product = Product::where('product_id', $productId)->first();
        $product->product_name = $productName;
        $product->product_price = $productPrice;
        $product->product_description = $productDescription;
        if($request->file('product_image') !== null) {
            $oldImageName = $product->product_image_name;
            Storage::delete('public/products/' . $oldImageName);
            $newImagePath = Storage::putFile('public/products', $request->file('product_image'), 'public');
            $newImageName = preg_split('/\//', $newImagePath);
            $product->product_image_name = end($newImageName);
        }

        $product->save();
        echo json_encode(["status" => 'ok']);
    }

    public function deleteProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::where('product_id', $productId)->first();
        Storage::delete('public/products/' . $product->product_image_name);
        $product->delete();

        echo json_encode(["status" => 'ok']);
    }

    // Функции панели владельца

    public function updateUser(Request $request)
    {
        $userId = $request->input('user_id');
        $userGroup = $request->input('user_group');
        $userAddress = $request->input('user_address');
        $userPhone = $request->input('user_phone');
        $user = User::where('user_id', $userId)->first();
        $user->user_group = $userGroup;
        $user->user_address = $userAddress;
        $user->user_phone = $userPhone;
        $user->save();

        echo json_encode(["status" => 'ok']);
    }

    public function deleteUser(Request $request)
    {
        $userId = $request->input('user_id');
        $user = User::where('user_id', $userId)->first();
        if($user->user_group === 'global') {
            return false;
        }
        $user->delete();
        echo json_encode(['status' => 'ok']);
    }

    // Вспомогательные функции загрузки страниц

    public function loadManagerTable()
    {
        $orders = Order::select('order_id', 'user_id', 'order_phone', 'order_address',
            'order_goods', 'order_additional', 'order_status', 'created_at');

        echo json_encode(["data" => $orders->get()]);
    }

    public function loadAdminTable()
    {
        echo json_encode([
            "data" => Product::select('product_id', 'product_name', 'product_price', 'product_image_name')->get()
        ]);
    }

    public function loadGlobalTable()
    {
        echo json_encode([
            "data" => User::select('user_id', 'user_email', 'user_address', 'user_phone', 'user_group')->get()
        ]);
    }
}
