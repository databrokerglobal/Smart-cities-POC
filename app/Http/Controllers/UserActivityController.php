<?php
/**
 *  
 *  User Activity Controller
 * 
 * This file is a part of the Databroker.Global package.
 *
 * (c) Databroker.Global
 *
 * @author    Databroker.Global
 * 
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Helper\SiteHelper;
use Session;

class UserActivityController extends Controller
{
     /**
     *  
     *   List page of user activity logs
     */

    public function list(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'user_activity');
        Session::put('menu_item_child_child', '');
        $logs = ActivityLog::orderby('created_at', 'desc')
                            ->get();
          
        $data = array('logs');
        return view('admin.logs.list', compact($data));
    }

    
}
