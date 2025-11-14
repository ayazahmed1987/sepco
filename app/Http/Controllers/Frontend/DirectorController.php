<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManagementPerson;
use App\Models\Page;
use App\Services\PageRendererService;

class DirectorController extends Controller
{
    public function __construct(
        protected PageRendererService $pageRendererService,
    ){}

    public function index(){
        $directors = ManagementPerson::where('status', 1)->where('type', 1)->get();
        $page = Page::where('slug', 'board-of-directors')->first();
        $renderedComponents = $page ? $this->pageRendererService->renderPageComponents($page) : [];
        return view('frontend.board-of-directors.index',compact('directors','renderedComponents'));
    }

    public function detail($slug){
        $director = ManagementPerson::where('status', 1)->where('type', 1)->where('slug', $slug)->first();
        if(!$director){
            return redirect()->back()->with('error','Director data not found!');
        }
        $page = Page::where('slug', 'board-of-directors')->first();
        $renderedComponents = $page ? $this->pageRendererService->renderPageComponents($page) : [];
        return view('frontend.board-of-directors.detail',compact('director','renderedComponents'));
    }
}
