<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    // Show edit form
    public function edit()
    {
        $setting = WebsiteSetting::firstOrCreate([]); // ensure record exists
        return view('backend.settings.edit', compact('setting'));
    }

    // Update settings
    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:255',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'copyright_text' => 'nullable|string|max:500',
			'location_map' => 'nullable|string|max:1000',
			'google_analytic' => 'nullable|string|max:500',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png,svg,webp|max:2048',
            'favicon' => 'nullable|file|mimes:png,ico|max:512',
        ]);

        $setting = WebsiteSetting::firstOrFail();
        $setting->update($data);
		
		if ($request->hasFile('logo')) {	
		$setting->clearMediaCollection('logo');
		$setting->addMedia($request->file('logo'))->toMediaCollection('logo');
		}
		
		if ($request->hasFile('favicon')) {	
		$setting->clearMediaCollection('favicon');
		$setting->addMedia($request->file('favicon'))->toMediaCollection('favicon');
		}
		
         activity()->causedBy(auth()->user())->performedOn($setting)->withProperties($data)->event('updated')->log('Update website setting');
		 
         return redirect()->back()->with('success', 'Website settings updated successfully!');
    }
}
