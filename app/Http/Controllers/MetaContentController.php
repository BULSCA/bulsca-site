<?php

namespace App\Http\Controllers;

use App\Services\MetaContentService;
use Illuminate\Http\Request;

class MetaContentController extends Controller
{
    protected $metaContent;

    public function __construct(MetaContentService $metaContent)
    {
        $this->metaContent = $metaContent;
    }

    /**
     * Display Meta content feed
     */
    public function index()
    {
        $posts = $this->metaContent->getLatestPosts(9);
        
        return view('meta-content.feed', compact('posts'));
    }

    /**
     * Get posts as JSON (for AJAX requests)
     */
    public function posts(Request $request)
    {
        $limit = $request->get('limit', 10);
        $posts = $this->metaContent->getLatestPosts($limit);
        
        return response()->json([
            'success' => true,
            'posts' => $posts,
        ]);
    }

    /**
     * Clear Meta content cache
     */
    public function clearCache()
    {
        $this->metaContent->clearCache();
        
        return redirect()->back()->with('success', 'Meta content cache cleared!');
    }
}