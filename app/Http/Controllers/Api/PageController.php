<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Http\Resources\PageResource;
use App\Http\Resources\PageCollection;

class PageController extends Controller
{
    /**
     * Get a list of pages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $pages = Page::with(['sections' => function($query) {
            $query->where('status', 'published')
                  ->orderBy('order', 'asc');
        }])
        ->where('status', 'published')
        ->orderBy('created_at', 'desc')
        ->get();
     //   dd($pages);
        $resource = PageResource::collection($pages);

        return response()->json($resource, 200, [],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Get a specific page by ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $page = Page::with(['sections' => function($query) {
            $query->where('status', 'published')
                  ->orderBy('order', 'asc');
        }])->where('status', 'published')
          ->findOrFail($id);

        $resource = new PageResource($page);

        return response()->json($resource, 200, [],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG);
    }

    /**
     * Get a specific page by slug.
     *
     * @param string $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function showBySlug($slug)
    {
        $page = Page::with(['sections' => function($query) {
            $query->where('status', 'published')
                  ->orderBy('order', 'asc');
        }])->where('status', 'published')
          ->where('slug', $slug)
          ->firstOrFail();

        $resource = new PageResource($page);

        return response()->json($resource, 200, [],
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG);
    }
}
