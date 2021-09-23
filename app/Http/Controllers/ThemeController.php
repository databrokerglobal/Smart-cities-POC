<?php
/**
 *  
 *  Theme Controller
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
use App\Models\Community;
use App\Models\Theme;
use Session;
use Image;
use App\Helper\SiteHelper;

class ThemeController extends Controller
{
     /**
     *  
     *   List page of themes
     */

    public function list(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'themes');
        Session::put('menu_item_child_child', '');
        $themes = Theme::with('communities')->orderby('created_at', 'desc')
                            ->get();          
        $data   = array('themes');
        return view('admin.themes.list', compact($data));
    }

    /**
     *  Publish/Unpublish theme
     * 
     */
    public function publish(Request $request){
        $themeIdx       = $request->themeIdx;
        $theme          = Theme::where('themeIdx', $themeIdx)->get()->first();
        $new['status']  = 1 - $theme->status;
        Theme::where('themeIdx', $themeIdx)->update($new);
        if($new['status'] == 1) {
            Session::flash('flash_success', 'Theme has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Theme has been Unpublished successfully'); 
        } 
        echo "success";
    }

    /**
     *  
     *  Add theme page
     */

    public function add(){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'themes');
        Session::put('menu_item_child_child', '');
        $communities    = Community::get();
        $detail         = "";
        $data           = array('detail','communities');        
        return view('admin.themes.add', compact($data));        
    }

     /**
     *  
     *  Edit theme page
     */

    public function edit($id){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'themes');
        Session::put('menu_item_child_child', '');
        $communities    = Community::get();
        $detail         = Theme::where('themeIdx', $id)->get()->first();
        if(!$detail){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $data           = array('id', 'detail','communities');
        return view('admin.themes.add', compact($data));
    }


    /**
     *  Add/Update theme
     * 
     * 
     */
    public function update(Request $request) {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'themes');
        Session::put('menu_item_child_child', '');
        if($request->input('themeIdx')) {
            $id         = $request->input('themeIdx');
            $data       = $request->all();
            unset($data['themeIdx']);
            unset($data['files']);
            Theme::find($id)->update($data); 
            Session::flash('flash_success', 'Theme has been updated successfully');           
        } else {
            $data           = $request->all();
            unset($data['files']);
            $insertedData   = Theme::create($data);
            $id             = $insertedData->themeIdx;
            Session::flash('flash_success', 'Theme has been added successfully');    
        }
        if ($request->hasFile('uploadedFile')) {
            $this->upload_attach($request, $id);            
        }        
        return "success";
    }
    /**
     *  
     *  upload the theme Image
     */
    public function upload_attach(Request $request, $id) {
            $getfiles = $request->file('uploadedFile');
            if (!file_exists('uploads/themes')) {
                mkdir('uploads/themes', 0777, true);
                mkdir('uploads/themes/large', 0777, true);
                mkdir('uploads/themes/medium', 0777, true);
                mkdir('uploads/themes/tiny', 0777, true);
                mkdir('uploads/themes/thumb', 0777, true);
            }
            $fileName = $id.'.jpg';              
            //image compress start
            SiteHelper::resizeAndUploadImage($getfiles,'THEME',$fileName);      
            Theme::find($id)->update(['image' => $fileName]);
            return "true";
    }
    /**
     *  
     *  Delete theme
     */
    public function delete(Request $request) {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'themes');
        Session::put('menu_item_child_child', '');
        $themeIdx   = $request->id;
        $board      = Theme::where('themeIdx', $themeIdx)->delete(); 
        Session::flash('flash_success', 'Theme has been deleted successfully'); 
        return "success";
       
    }
}
