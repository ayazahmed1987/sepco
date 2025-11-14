<?php

namespace App\Services;

use App\Models\Page;
use App\Models\PageComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;

class PageRendererService
{
    /**
     * Renders components for a given Page model.
     *
     * @param Page $page The Page model instance.
     * @return array An array of rendered HTML strings for each component.
     */
    public function renderPageComponents(Page $page): array
    {
		$renderedComponents = [];
        $page->loadMissing('components.component');

        foreach ($page->components as $pageComponent) {
            try {
                if (!$pageComponent->relationLoaded('component') || !$pageComponent->component) {
                    Log::warning('Component relationship not loaded or null for PageComponent ID: ' . $pageComponent->id);
                    continue;
                }
                $component = $pageComponent->component;
                $fieldsData = $pageComponent->fields_data ?? [];
                $renderedComponents[] = Blade::render($component->design, [
                    'data' => $fieldsData,
                    'component' => $component,
                    'pageComponent' => $pageComponent
                ]);
            } catch (\Throwable $e) {
                Log::error(
                    'Component rendering failed for PageComponent ID: ' . ($pageComponent->id ?? 'N/A'),
                    ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
                );
                continue;
            }
        }
        return $renderedComponents;
    }

    /**
     * Finds the homepage and renders its components.
     *
     * @return array A tuple containing the homepage model and an array of rendered HTML strings.
     */
    public function renderHomepage(): array
    {
        $homepage = Page::with(['components.component'])->where('is_homepage', 1)->first();
        if (!$homepage) {
            Log::warning('No homepage found with is_homepage = 1.');
            return [null, []];
        }
        $renderedComponents = $this->renderPageComponents($homepage);
        return [$homepage, $renderedComponents];
    }
}