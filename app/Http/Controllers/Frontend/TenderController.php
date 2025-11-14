<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Tender;
use App\Services\PageRendererService;
use App\Services\TenderFilterService;

class TenderController extends Controller
{
    public function __construct(
        protected PageRendererService $pageRendererService,
        protected TenderFilterService $tenderFilterService,
    ){}

    public function index(Request $request)
    {
        $filterResult = $this->tenderFilterService->filter($request);
        $query = $filterResult['query'];
        
        $tenders = $query
        ->latest('published_date')
        ->paginate(2);

        $page = cache()->rememberForever('page_tender', fn() =>
            Page::where('slug', 'tenders')->first()
        );

        $renderedComponents = cache()->remember('tender_components', now()->addHours(1), fn() =>
            $page ? $this->pageRendererService->renderPageComponents($page) : []
        );

        if ($request->ajax()) {
            return view('frontend.tenders.partials.tenders', compact('tenders'))->render();
        }

        return view('frontend.tenders.index', [
            'tenders' => $tenders,
            'page' => $page,
            'renderedComponents' => $renderedComponents,
            'years' => $filterResult['years'],
            'selectedYear' => $filterResult['selectedYear'],
            'selectedStatus' => $filterResult['selectedStatus']
        ]);
    }


    public function getAttachments($id)
    {
        $tender = Tender::with('tenderAttachments')->findOrFail($id);

        return response()->json([
            'html' => view('frontend.tenders.modals.tender-attachments', compact('tender'))->render()
        ]);
    }
}
