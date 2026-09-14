<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\AwardController as AdminAwardController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogPostController as AdminBlogPostController;
use App\Http\Controllers\Admin\ClientController as AdminClientController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\HeroSlideController as AdminHeroSlideController;
use App\Http\Controllers\Admin\JobVacancyController as AdminJobVacancyController;
use App\Http\Controllers\Admin\MessageController as AdminMessageController;
use App\Http\Controllers\Admin\PageContentController as AdminPageContentController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ProjectImageController as AdminProjectImageController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AwardController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Dynamic XML Sitemap for SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// About Us
Route::get('/about-us', [AboutController::class, 'index'])->name('about');

// Clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients');

// Products & LNG Business Lines (2-Level Hierarchy)
Route::get('/products', [ServiceController::class, 'index'])->name('products.index');
Route::get('/products/{parent}', [ServiceController::class, 'show'])->name('products.show');
Route::get('/products/{parent}/{child}', [ServiceController::class, 'showChild'])->name('products.child');
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{parent}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/services/{parent}/{child}', [ServiceController::class, 'showChild'])->name('services.child');

// Portfolio Details & Categories
Route::get('/portfolio/{slug}', [ProjectController::class, 'show'])->name('portfolio.show');
Route::get('/portfolio-cat/{slug}', [ProjectController::class, 'byCategory'])->name('portfolio.category');

// Awards & Publications
Route::get('/awards-publications', [AwardController::class, 'index'])->name('awards.index');
Route::get('/awards-publications/{slug}', [AwardController::class, 'show'])->name('awards.show');

// Our Blog & Insights
Route::get('/blog', [BlogController::class, 'index'])->name('blog.main');
Route::get('/our-blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/our-blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.direct');

// Contact Us
Route::get('/contact', [ContactController::class, 'index'])->name('contact.direct');
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

// Career
Route::get('/career', [CareerController::class, 'index'])->name('career');

// Newsletter Subscription
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');

// AI Chatbot Assistant (Powered by Gemini)
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
Route::get('/chatbot/suggestions', [ChatbotController::class, 'getSuggestions'])->name('chatbot.suggestions');


/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Manual Session Auth, Without Breeze / Vite)
|--------------------------------------------------------------------------
*/

// Guest Admin Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Authenticated Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Dashboard Overview
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Core Module Resources
    Route::resource('projects', AdminProjectController::class);
    Route::delete('projects/{project}/images/{image}', [AdminProjectImageController::class, 'destroy'])->name('projects.images.destroy');
    Route::post('projects/{project}/images/reorder', [AdminProjectImageController::class, 'reorder'])->name('projects.images.reorder');

    Route::resource('services', AdminServiceController::class);
    Route::resource('clients', AdminClientController::class);
    Route::resource('awards', AdminAwardController::class);
    Route::resource('job-vacancies', AdminJobVacancyController::class);
    Route::resource('blog-categories', AdminBlogCategoryController::class);
    Route::resource('blog-posts', AdminBlogPostController::class);
    Route::resource('hero-slides', AdminHeroSlideController::class);
    Route::resource('testimonials', AdminTestimonialController::class);

    // Site Settings (Grouped Form)
    Route::get('settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [AdminSettingController::class, 'update'])->name('settings.update');

    // Page Content Copywriting (Grouped Form)
    Route::get('page-contents', [AdminPageContentController::class, 'edit'])->name('page-contents.edit');
    Route::put('page-contents', [AdminPageContentController::class, 'update'])->name('page-contents.update');

    // Inbox Messages
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminMessageController::class, 'show'])->name('messages.show');
    Route::patch('messages/{message}/read', [AdminMessageController::class, 'markAsRead'])->name('messages.read');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');

    // Newsletter Subscribers
    Route::get('subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::get('subscribers/export', [AdminSubscriberController::class, 'export'])->name('subscribers.export');
    Route::delete('subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');

    // Admin Users Management
    Route::resource('users', AdminUserController::class);

});
