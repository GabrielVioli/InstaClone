<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rotas Públicas
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/verify/{id}/{hash}', [\App\Http\Controllers\VerifyEmailController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
});

// Rotas Protegidas
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
    });

    // Feed
    Route::get('/feed', [FeedController::class, 'index']);

    // Usuários
    Route::prefix('users')->group(function () {
        Route::get('/suggestions', [UserController::class, 'suggestions']);
        Route::get('/search', [UserController::class, 'search']);

        // Perfil Próprio
        Route::put('/me', [UserController::class, 'updateMe']);
        Route::post('/me/avatar', [UserController::class, 'uploadAvatar']);

        // Ações específicas (antes do /{username} para evitar conflito)
        Route::get('/{id}/posts', [UserController::class, 'posts']);
        Route::post('/{id}/follow', [FollowController::class, 'store']);
        Route::delete('/{id}/follow', [FollowController::class, 'destroy']);
        Route::get('/{id}/followers', [FollowController::class, 'followers']);
        Route::get('/{id}/following', [FollowController::class, 'following']);
        Route::get('/{id}/is-following', [FollowController::class, 'isFollowing']);

        // Perfis de Outros Usuários (por último)
        Route::get('/{username}', [UserController::class, 'show']);
    });

    // Posts
    Route::prefix('posts')->group(function () {
        Route::post('/', [PostController::class, 'store']);
        Route::get('/{id}', [PostController::class, 'show']);
        Route::put('/{id}', [PostController::class, 'update']);
        Route::delete('/{id}', [PostController::class, 'destroy']);

        // Curtidas
        Route::get('/{id}/likes', [LikeController::class, 'index']);
        Route::post('/{id}/like', [LikeController::class, 'store']);
        Route::delete('/{id}/like', [LikeController::class, 'destroy']);

        // Comentários
        Route::get('/{id}/comments', [CommentController::class, 'index']);
        Route::post('/{id}/comments', [CommentController::class, 'store']);
    });

    // Comentários (Ações Diretas)
    Route::put('comments/{id}', [CommentController::class, 'update']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);
});
