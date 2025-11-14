<?php

namespace App\Services;

use App\Models\Page;
use App\Models\CustomPost;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;

class CustomPostRendererService
{
    /**
     * Renders customposts for a given Page model.
     *
     * @param Page $page The Page model instance.
     * @return array An array of rendered HTML strings for each component.
     */
    public function renderPageCustomposts(Page $page) //: array
    {

		$renderedCustomposts = [];

        $page->loadMissing('customposts.custompostdata');
		
        foreach ($page->customposts as $pageCustompost) {

            try {
				
				/*
				if (!$pageCustompost->relationLoaded('custompostdata') || !$pageCustompost->custompostdata) {
                    Log::warning('Custompost relationship not loaded or null for Custompost ID: ' . $pageCustompost->id);
                    continue;
                }
                $custompostdatas = $pageCustompost->custompostdata;
				
				foreach ($custompostdatas as $custompostdata) {
                $fieldsData = $custompostdata->fields_data ?? [];
                $renderedCustomposts[$pageCustompost->table_name][] = Blade::render($pageCustompost->design, [
                    'datas' => $fieldsData,
                    'custompostdatas' => $custompostdatas,
                    'custompost' => $pageCustompost
                ]);
				}
				*/
				

				$renderedCustomposts[$pageCustompost->table_name] = Blade::render($pageCustompost->design, [ 'page' => $page, 'is_homepage' => $page->is_homepage ?? 0, 'items' => $pageCustompost->custompostdata ]);
				
				//$renderedCustomposts = Blade::render($pageCustompost->design, [ 'items' => $pageCustompost->custompostdata ]);
				//$renderedCustomposts = Blade::render($pageCustompost->design, [ 'custompost' => $pageCustompost ]);
				
            } catch (\Throwable $e) {
                Log::error(
                    'Custompost rendering failed for PageCustompost ID: ' . ($pageCustompost->id ?? 'N/A'),
                    ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]
                );
                continue;
            }

        }
        return $renderedCustomposts;
		
		
    }

}


/*
<div class="slider_list owl-carousel owl-loaded owl-drag">
    @foreach($items as $item)
	<div class="owl-item" style="width:100%;"><section class="hero_area box_two d-flex align-items-center" style="background: url({{ asset('frontend/assets/images/slider-1.jpg') }}); background-size:cover!important;">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-12">
					<!-- hero content -->
					<div class="hero_content style_four">
						<h3>{{ $item->fields_data['subtitle'] }}</h3>
						<h1>{{ $item->fields_data['title'] }}</h1>
						<p>{{ $item->fields_data['description'] }}</p>
							<!-- slider button -->
						<div class="slider_button">
							<div class="hero_btn animate_buton home_four">
								<a href="{{ $item->fields_data['url'] }}">Learn More <span style="top: 68px; left: 15.5px;"></span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section></div>
    @endforeach
	</div>
*/