<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductSpec;
use App\Models\Setting;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ProductSpecification;
use Illuminate\Support\Facades\Auth;
use App\Events\CartUpdated;

class CartController extends Controller
{
    public function index(Request $request)
    {

        if (session()->has('cart')) {
            $cart = session()->get('cart', []);
        } else {
            $cart = [];
        }

        if (empty($cart)) {
            return redirect()->route('home')->with('error', '購物車是空的');
        }
        $total = 0;

        // 計算總價
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // 獲取運費
        $shippingFee = 0;

        // 獲取購物車中最後一個商品的 product_id
        $cartReferrer = !empty($cart) ? end($cart)['product_id'] : '';

        return view(
            'frontend.cart.index',
            compact('cart', 'total', 'shippingFee', 'cartReferrer')
        );
    }

    public function addToCart(Request $request, $redirect = true)
    {

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'spec_id' => 'required|exists:product_specs,id',
            'quantity' => 'required|integer|min:1',
            'checkout_direct' => 'boolean'
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $specification = ProductSpec::findOrFail($validated['spec_id']);

        // 獲取當前購物車
        $cart = session()->get('cart', []);

        // 新增商品到購物車，使用規格價格
        $cart[] = [
            'product_id' => $validated['product_id'],
            'spec_id' => $validated['spec_id'],
            'quantity' => $validated['quantity'],
            'price' => $specification->price,  // 改用規格價格
            'product_name' => $product->name,
            'spec_name' => $specification->name,
            'primary_image' => asset('storage/products/' . $validated['product_id'] . '/' . $product->primaryImage->image_path)
        ];

        session()->put('cart', $cart);
        // // 廣播購物車數量更新事件
        // broadcast(new CartUpdated(count($cart)));

        // 據 checkout_direct 參數決定跳轉
        if ($request->boolean('checkout_direct')) {
            return redirect()->route('checkout.index');
        }

        if ($redirect) {
            return redirect()->route('cart.index');
        } else {
            return response()->json([
                'success' => true,
                'message' => '商品已加入購物車'
            ]);
        }
    }

    public function add(Request $request)
    {

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'spec_id' => 'required|exists:product_specs,id',
            'quantity' => 'required|integer|min:1',
            'checkout_direct' => 'boolean'
        ]);

        // 獲取當前購物車
        $cart = session()->get('cart', []);

        // 新增商品到購物車
        $cartItem = [
            'product_id' => $validated['product_id'],
            'spec_id' => $validated['spec_id'],
            'quantity' => $validated['quantity']
        ];

        // 存储到购物车 session
        $cart[] = $cartItem;
        session()->put('cart', $cart);

        // 廣播購物車數量更新事件
        broadcast(new CartUpdated(count($cart)));

        // 根据 checkout_direct 参数決定跳转
        if ($request->boolean('checkout_direct')) {
            return redirect()->route('checkout');
        }

        return redirect()->back()->with('success', '商品已加入購物車');
    }

    public function update(Request $request)
    {

        $request->validate([
            'quantity' => 'required|integer|min:1',
            'item_id' => 'required|integer',
        ]);

        $cart = session()->get('cart', []);
        $item = $cart[$request->item_id];

        $item['quantity'] = $request->quantity;
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => '數量已更新',
            'total' => number_format($item['price'] * $item['quantity'])
        ]);
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|integer',
        ]);

        $cart = session()->get('cart', []);

        // 使用 item_id 作为索引来删除商品
        if (isset($cart[$validated['item_id']])) {
            unset($cart[$validated['item_id']]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => '商品已從購物車移除'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => '商品不存在'
        ], 404);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'spec_id' => 'required|exists:product_specs,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        $spec = ProductSpec::findOrFail($request->spec_id);

        // 創建購物車項目的唯一鍵值
        $cartKey = $product->id . '-' . $spec->id;

        // 準備購物車項目資料
        $cartItem = [
            'product_id' => $product->id,
            'product_name' => $product->name,
            'spec_id' => $spec->id,
            'spec_name' => $spec->name,  // 確保這裡有規格名稱
            'price' => $product->cash_price,
            'quantity' => $request->quantity,
            'primary_image' => $product->primaryImageUrl
        ];

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $request->quantity;
        } else {
            $cart[$cartKey] = $cartItem;
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', '商品已加入購物車');
    }

    public function updateQuantity(Request $request)
    {

        $itemId = $request->input('item_id');
        $quantity = $request->input('quantity');

        // 獲取購物車內容
        $cart = session()->get('cart', []);

        // 查找對應商品並更新數量
        foreach ($cart as $key => $item) {
            if ($key == $itemId) {
                $cart[$key]['quantity'] = $quantity;
                session()->put('cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => '數量已更新'
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => '找不到該商品'
        ], 404);
    }
}
