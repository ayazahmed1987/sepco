<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\CustomPost;
use App\Models\CustomPostData;


class SearchController extends Controller
{
    public function index(Request $request){
    $query = trim($request->input('q'));

    // If query empty → return blank view
    if (!$query) {
        $results = collect(); // use collection for consistency
        return view('frontend.searchresult', compact('results', 'query'));
    }

    /** -------------------------------
     * 1️⃣  PAGES
     * ------------------------------*/
    $pages = Page::select('id', 'title', 'slug', 'description')
        ->where(function ($q) use ($query) {
            $q->where('title', 'like', "%{$query}%")
              ->orWhere('description', 'like', "%{$query}%");
        })
        ->get()
        ->map(function ($item) {
            return (object) [
                'title' => $item->title,
                'type'  => 'page',
                'url'   => route('website.page.show', $item->slug),
            ];
        });


    /** -------------------------------
     * 2️⃣  CUSTOM POST DATA — NEWS/EVENT
     * ------------------------------*/
    $news_event = CustomPostData::select('id', 'custom_post_id', 'fields_data')
        ->where('custom_post_id', 2)
        ->get()
        ->filter(function ($item) use ($query) {
            $title = data_get($item->fields_data, 'title', '');
            $desc  = data_get($item->fields_data, 'description', '');
            return str_contains(strtolower($title . ' ' . $desc), strtolower($query));
        })
        ->map(function ($item) {
            $title = data_get($item->fields_data, 'title', '');
            return (object) [
                'title' => $title,
                'type'  => 'news',
                'url'   => route('website.post.show', [$item->id, Str::slug($title)]),
            ];
        });


    /** -------------------------------
     * 3️⃣  CUSTOM POST DATA — TEAMS
     * ------------------------------*/
    $teams = CustomPostData::select('id', 'custom_post_id', 'fields_data')
        ->where('custom_post_id', 4)
        ->get()
        ->filter(function ($item) use ($query) {
            $name    = data_get($item->fields_data, 'name', '');
            $content = data_get($item->fields_data, 'content', '');
            return str_contains(strtolower($name . ' ' . $content), strtolower($query));
        })
        ->map(function ($item) {
            $name = data_get($item->fields_data, 'name', '');
            return (object) [
                'title' => $name,
                'type'  => 'teams',
                'url'   => route('website.post.show', [$item->id, Str::slug($name)]),
            ];
        });


    /** -------------------------------
     * 4️⃣  Combine All Results
     * ------------------------------*/
    $results = $pages->concat($news_event)->concat($teams);

    return view('frontend.searchresult', compact('results', 'query'));
    }
	
	
	public function index_old(Request $request)
    {

		if( $request->input('q')){

		$query = $request->input('q');

    // --- PAGES ---
	$pages = Page::select('id', 'title', 'slug', 'description')->where('title', 'like', "%{$query}%")->orWhere('description', 'like', "%{$query}%")
		->get()->map(function ($item) {
			$item->title = $item->title;
			$item->type = 'page';
			$item->url  = route('website.page.show', $item->slug);
			return $item;
		});
		
	// --- CUSTOM POSTS DATA ---  
	//News Event
	$news_event = CustomPostData::select('id', 'custom_post_id', 'fields_data')->where('custom_post_id', 2)->get()->filter(function($item) use ($query) {
    $title = data_get($item->fields_data, 'title', '');
    $desc  = data_get($item->fields_data, 'description', '');
    return str_contains(strtolower($title . ' ' . $desc), strtolower($query));
    })->map(function ($item) {
		        $item->title = data_get($item->fields_data, 'title', '');
                $item->type = 'news';
                $item->url  = route('website.post.show', [$item->id, Str::slug(data_get($item->fields_data, 'title', ''))]);
                return $item;
            });
	
    //Teams	
	$teams = CustomPostData::select('id', 'custom_post_id', 'fields_data')->where('custom_post_id', 4)->get()->filter(function($item) use ($query) {
    $name = data_get($item->fields_data, 'name', '');
    $content  = data_get($item->fields_data, 'content', '');
    return str_contains(strtolower($name . ' ' . $content), strtolower($query));
    })->map(function ($item) {
		        $item->title = data_get($item->fields_data, 'name', '');
                $item->type = 'teams';
                $item->url  = route('website.post.show', [$item->id, Str::slug(data_get($item->fields_data, 'name', ''))]);
                return $item;
            });		
		


        // Combine all collections
		$results = $pages->concat($news_event)->concat($teams);
		//dd($results->toArray());
            return view('frontend.searchresult', compact('results', 'query'));
		}else{
            $results = array();
            return view('frontend.searchresult', compact('results'));
           
        }
    }
}
