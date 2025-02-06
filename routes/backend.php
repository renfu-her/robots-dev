<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminNoteController;
use App\Http\Controllers\Admin\AdvertController;
use App\Http\Controllers\Admin\{
    AdminController,
    ActivityController,
    AdController,
    CartController,
    CategoryController,
    OrderController,
    ProductController,
    ProductImageController,
    ProductSpecificationController,
    PostController,
    EmailSettingController,
    SettingController,
    ProductSpecController,
    UploadController,
    FaqController,
    FaqCategoryController,
    SealKnowledgeCategoryController,
    SealKnowledgeController,
    MemberController,
    HomeAdsController,
    SiteSettingController,
    PostCategoryController,
    FreeShippingController,
    AboutUsController,
    FeedbackController,
    NewsController,
    AlbumController
};


// 管理員登入
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('post.login');
    Route::match(['get', 'post'], '/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::post('products/{product}/sort-images', [ProductController::class, 'sortImages'])->name('products.sort-images');
});


Route::group([
    'middleware' => ['admin.auth'],
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    // Route::resource('categories', AdminCategoryController::class);
    // Route::resource('notes', AdminNoteController::class);

    // 廣告管理     
    Route::resource('ads', AdController::class)->except(['show']);

    // 分類管理
    Route::resource('categories', CategoryController::class);

    // 購物車管理
    Route::resource('carts', CartController::class);

    // 產品管理
    Route::resource('products', ProductController::class);
    Route::post('upload-image', [UploadController::class, 'uploadImage'])->name('upload.image');

    // 產品圖片相關路由
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        // 更新圖片排序
        Route::post('{product}/images/order', [ProductImageController::class, 'updateOrder'])->name('images.order');
        // 設置主圖
        Route::post('{product}/images/{image}/primary', [ProductImageController::class, 'setPrimary'])->name('images.primary');
        // 刪除主圖
        Route::delete('image/destroy', [ProductController::class, 'destroyImage'])->name('image.destroy');
        // 刪除圖片
        Route::delete('images/destroy', [ProductImageController::class, 'destroy'])->name('images.destroy');
    });

    // 常見問題管理
    Route::resource('faqs', FaqController::class);
    Route::resource('faq-categories', FaqCategoryController::class);

    // 反饋管理
    Route::resource('feedbacks', FeedbackController::class)->only(['index', 'show', 'destroy']);

    // 活動管理
    Route::resource('activities', ActivityController::class);
    Route::post('activities/{activity}/sort', [ActivityController::class, 'updateSort'])->name('activities.sort');
    Route::post('activities/{activity}/toggle-active', [ActivityController::class, 'toggleActive'])->name('activities.toggle-active');

    // 會員管理
    Route::resource('members', MemberController::class);
    // 會員狀態切換
    Route::post('members/{member}/toggle-status', [App\Http\Controllers\Admin\MemberController::class, 'toggleStatus'])
        ->name('members.toggle-status');

    // 管理員管理
    Route::resource('admins', AdminController::class);
    Route::post('admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])
        ->name('admins.toggle-status');


    // 文章管理
    Route::resource('posts', PostController::class);

    // 關於我們管理
    Route::resource('about-us', AboutUsController::class);

    // 規格管理
    Route::resource('specifications', ProductSpecificationController::class);

    // 郵件設定
    Route::resource('email-settings', EmailSettingController::class);
    Route::post('email-settings/{emailSetting}/toggle-active', [EmailSettingController::class, 'toggleActive'])
        ->name('email-settings.toggle-active');

    // 系統設定
    Route::resource('settings', SettingController::class);

    // 產品規格管理
    Route::resource('products.specs', ProductSpecController::class)->except(['show']);
    Route::post('products/{product}/specs/{spec}/toggle-active', [ProductSpecController::class, 'toggleActive'])
        ->name('products.specs.toggle-active');

    // 訂單管理
    Route::resource('orders', OrderController::class);
    Route::post('orders/update-shipping-status', [OrderController::class, 'updateShippingStatus'])
        ->name('orders.update-shipping-status');
    Route::put('orders/{order}/update-status', [OrderController::class, 'updateStatus'])
        ->name('orders.update-status');

    // 首頁廣告管理
    Route::resource('home-ads', HomeAdsController::class)->except(['show']);
    Route::post('home-ads/update-order', [HomeAdsController::class, 'updateOrder'])->name('home-ads.update-order');

    // 廣告狀態切換
    Route::post('ads/{ad}/toggle-active', [AdController::class, 'toggleActive'])
        ->name('ads.toggle-active');

    // 首頁小廣告狀態切換
    Route::post('home-ads/{homeAd}/toggle-active', [HomeAdsController::class, 'toggleActive'])
        ->name('home-ads.toggle-active');

    // FAQ 分類狀態切換
    Route::post('faq-categories/{category}/toggle-active', [FaqCategoryController::class, 'toggleActive'])
        ->name('faq-categories.toggle-active');

    // FAQ 狀態切換
    Route::post('faqs/{faq}/toggle-active', [FaqController::class, 'toggleActive'])
        ->name('faqs.toggle-active');

    // 網站設定
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::put('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');

    Route::get('refresh-captcha', [AdminAuthController::class, 'refreshCaptcha'])
        ->name('refresh.captcha');

    // PostCategory 路由
    Route::resource('post-categories', PostCategoryController::class);

    // 免運費活動管理
    Route::resource('free-shippings', FreeShippingController::class);
    Route::post('free-shippings/{freeShipping}/toggle-active', [FreeShippingController::class, 'toggleActive'])
        ->name('free-shippings.toggle-active');

    // 最新消息管理
    Route::resource('news', NewsController::class);

    // 相簿管理
    Route::resource('albums', AlbumController::class);
});
