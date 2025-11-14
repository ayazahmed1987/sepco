<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Tender;
use App\Models\TechnicalEvaluation;
use App\Services\PageRendererService;
use App\Services\TechnicalEvaluationFilterService;

class TechnicalEvaluationController extends Controller
{
    public function __construct(
        protected PageRendererService $pageRendererService,
        protected TechnicalEvaluationFilterService $technicalEvaluationFilterService,
    ) {}

    public function index(Request $request)
    {
        $filterResult = $this->technicalEvaluationFilterService->filter($request);
        $query = $filterResult['query'];

        $technical_evaluations = $query
            ->select(['id', 'tender_id', 'published_date', 'file'])
            ->latest('published_date')
            ->paginate(2);

        $page = cache()->rememberForever(
            'page_technical_evaluations',
            fn() =>
            Page::where('slug', 'technical-evaluations')->first()
        );

        $renderedComponents = cache()->remember(
            'technical_evaluations_components',
            now()->addHours(1),
            fn() =>
            $page ? $this->pageRendererService->renderPageComponents($page) : []
        );

        if ($request->ajax()) {
            return view('frontend.tenders.technical-evaluations.partials.technical-evaluations', compact('technical_evaluations'))->render();
        }
        return view('frontend.tenders.technical-evaluations.index', [
            'technical_evaluations' => $technical_evaluations,
            'page' => $page,
            'renderedComponents' => $renderedComponents,
            'years' => $filterResult['years'],
            'selectedYear' => $filterResult['selectedYear'],
            'selectedStatus' => $filterResult['selectedStatus']
        ]);
    }
}
