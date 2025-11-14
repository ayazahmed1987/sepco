<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PageRendererService;
use App\Services\CustomPostRendererService;
use App\Models\Page;
use App\Models\CustomPostData;
use App\Models\Grc;

class PageController extends Controller
{
    protected $pageRendererService;
	protected $custompostRendererService;
    
    public function __construct(PageRendererService $pageRendererService, CustomPostRendererService $custompostRendererService)
    {
        $this->pageRendererService = $pageRendererService;
		$this->custompostRendererService = $custompostRendererService;
    }

    public function show($slug){
        try {
            $page = Page::where('slug', $slug)->first();
            if (!$page) {
                abort(404);
            }
            $renderedComponents = $this->pageRendererService->renderPageComponents($page);
			
			$renderedCustomposts = $this->custompostRendererService->renderPageCustomposts($page);
			
			//dump($renderedCustomposts);
			
            return view('frontend.dynamic-pages.show', compact('page', 'renderedComponents', 'renderedCustomposts'));
        } catch (\Throwable $e) {
            \Log::error('Error fetching/rendering homepage:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            abort(404);
        }
    }
	
	public function postshow($id, $title = null){
        try {
			//dump($id);
			//dump($title);
			
            $post = CustomPostData::where('id', $id)->first();
            if (!$post) {
                abort(404);
            }
            return view('frontend.dynamic-pages.postshow', compact('post'));
        } catch (\Throwable $e) {
            \Log::error('Error fetching/rendering homepage:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            abort(404);
        }
    }

    public function grc(){
        try {
            $page = Page::where('slug', 'grc')->first();
            if (!$page) {
                abort(404);
            }
            $renderedComponents = $this->pageRendererService->renderPageComponents($page);
            $grcs = Grc::where('status',1)->get();
            return view('frontend.tenders.grc.index', compact('page', 'renderedComponents','grcs'));
        } catch (\Throwable $e) {
            \Log::error('Error fetching/rendering GRC:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            abort(404);
        }
    }
}
