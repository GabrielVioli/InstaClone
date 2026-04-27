<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Services\FeedService;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function __construct(private FeedService $feedService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = $this->feedService->index($request->user());

        return PostResource::collection($posts);
    }
}
