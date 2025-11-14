<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\CustomPostData;
use Illuminate\Support\Facades\Blade;
use App\Services\PageRendererService;
use App\Services\CustomPostRendererService;
use App\Mail\ContactFormSubmission;
use Illuminate\Support\Facades\Mail;
use Spatie\Sitemap\Sitemap;

class WebsiteController extends Controller
{
    protected $pageRendererService;
	protected $custompostRendererService;
    
    public function __construct(PageRendererService $pageRendererService, CustomPostRendererService $custompostRendererService)
    {
        $this->pageRendererService = $pageRendererService;
		$this->custompostRendererService = $custompostRendererService;
    }
    
    public function index(){
        try {
            list($homepage, $renderedComponents) = $this->pageRendererService->renderHomepage();
			$renderedCustomposts = $this->custompostRendererService->renderPageCustomposts($homepage);
            if (!$homepage) {
                abort(404);
            }
			
			//dump($renderedCustomposts['hero_slider']);
            return view('frontend.homepage', compact('homepage', 'renderedComponents', 'renderedCustomposts'));
        } catch (\Throwable $e) {
            \Log::error('Error fetching/rendering homepage:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            abort(404);
        }
    }

    public function contact(){
        return view('frontend.contact');
    }

    public function contactPost(Request $request){
            $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'type'    => 'required|in:Query,Feedback,Complaint',
            'message' => 'required|string',
        ]);
        Mail::to(env('CONTACT_EMAILS_ADMINISTRATOR', 'ayaz@a2zcreatorz.com'))
            ->send(new ContactFormSubmission($validated));

        return redirect()->back()->with('success', 'Your message has been sent!');
    }
	
	
	
	public function sitemap(){

	// Manually create sitemap
        $sitemap = Sitemap::create();

        // Static pages
        $sitemap->add('/');
        $sitemap->add('/contact');

        // Dynamic pages
        $pages = Page::all();
		$news_events = CustomPostData::where('custom_post_id', 2)->get();
		$teams = CustomPostData::where('custom_post_id', 4)->get();
		
        foreach ($pages as $page) {
            $sitemap->add("/page/{$page->slug}");
        }
		
		foreach ($news_events as $post) {
			$sitemap->add("/post/{$post->id}/" . Str::slug($post->fields_data['title']));
        }
		
		foreach ($teams as $post) {
			$sitemap->add("/post/{$post->id}/" . Str::slug($post->fields_data['name']));
        }


         return $sitemap;
        //$sitemap->writeToFile(public_path('sitemap.xml'));

    }
	
	
}
