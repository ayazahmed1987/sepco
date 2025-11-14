<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Log;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function index(){
        // Permission::create(['guard_name' => 'admin', 'name' => 'jobs-list']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'jobs-edit']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'jobs-create']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'jobs-delete']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'edit-admin']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'delete-admin']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'list-admin']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'add-role']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'edit-role']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'delete-role']);
        // Permission::create(['guard_name' => 'admin', 'name' => 'list-role']);
        return view('backend.pages.index');
    }

    public function logs(){
        $logs=Log::get();
        return view('backend.logs.index',compact('logs'));
    }

    public function cvReview(){
        return view('backend.curriculum-vitae.index');
    }

}
