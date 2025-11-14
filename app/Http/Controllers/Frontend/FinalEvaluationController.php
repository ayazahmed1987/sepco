<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Tender;
use App\Models\FinalEvaluation;
use App\Services\PageRendererService;
use App\Services\FinalEvaluationFilterService;

class FinalEvaluationController extends Controller
{
    public function __construct(
        protected PageRendererService $pageRendererService,
        protected FinalEvaluationFilterService $finalEvaluationFilterService,
    ) {}

    public function index(Request $request)
    {
        $filterResult = $this->finalEvaluationFilterService->filter($request);
        $query = $filterResult['query'];

        $final_evaluations = $query
            ->select(['id', 'tender_id', 'published_date', 'file'])
            ->latest('published_date')
            ->paginate(2);

        $page = cache()->rememberForever(
            'page_final_evaluations',
            fn() =>
            Page::where('slug', 'final-evaluations')->first()
        );

        $renderedComponents = cache()->remember(
            'final_evaluations_components',
            now()->addHours(1),
            fn() =>
            $page ? $this->pageRendererService->renderPageComponents($page) : []
        );

        if ($request->ajax()) {
            return view('frontend.tenders.final-evaluations.partials.final-evaluations', compact('final_evaluations'))->render();
        }
        return view('frontend.tenders.final-evaluations.index', [
            'final_evaluations' => $final_evaluations,
            'page' => $page,
            'renderedComponents' => $renderedComponents,
            'years' => $filterResult['years'],
            'selectedYear' => $filterResult['selectedYear'],
            'selectedStatus' => $filterResult['selectedStatus']
        ]);
    }
}
