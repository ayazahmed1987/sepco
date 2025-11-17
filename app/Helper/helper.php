<?php
use App\Models\Admin;
use App\Models\Page;
use App\Models\CustomPostData;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;


if(!function_exists('is_homepage'))
{
    function is_homepage()
    {
        return request()->is('/') || request()->routeIs('website.index');
    }
}
if(!function_exists('pages_count_admin'))
{
    function pages_count_admin()
    {
    $items = Page::get();
    return $items->count();
    }
}
if(!function_exists('custom_post_data_count_admin'))
{
    function custom_post_data_count_admin($id)
    {
    $items = CustomPostData::where('custom_post_id', $id)->get();
    return $items->count();
    }
}




if(!function_exists('user_count_admin'))
{
    function user_count_admin()
    {
    $admins = Admin::get();
    return $admins->count();
    }
}

if(!function_exists('roles_count_admin'))
{
    function roles_count_admin()
    {
    $Role = Role::get();
    return $Role->count();
    }
}
if(!function_exists('FormatLink'))
{
    function FormatLink($link) {
        if (Str::startsWith($link, 'route:')) {
            try{
                $parts = explode('||', $link);
                $routeName = Str::after(array_shift($parts), 'route:');
                return route($routeName, $parts[0]);
            }catch(\Exception $e){
                return "#";
            }
        }
        return $link;
    }
}


?>