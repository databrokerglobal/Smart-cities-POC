<?php
/**
 *  
 *  Configuration Controller
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
use App\Models\Configuration;
use App\Models\SiteTheme;
use Session;
use Image;

class ConfigurationController extends Controller
{
    /**
     *  
     *   List page
     */

    public function list(Request $request){
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'theming');
        Session::put('menu_item_child_child', '');
        $settings = SiteTheme::orderby('created_at', 'desc')
                            ->get();
       
          
        $data = array('settings');
        return view('admin.settings.list', compact($data));
    }
    /**
     * 
     * Configuration list
     * 
     */
    public function configurationList(Request $request){
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'configuration');
        Session::put('menu_item_child_child', '');
        $settings = Configuration::orderby('created_at', 'desc')
                            ->get();
       
        $data = array('settings');
        return view('admin.settings.configurations_list', compact($data));
    }

    /**
     *  Partner Publish the Item
     * 
     * 
     */

    public function publish(Request $request){
        $id          = $request->id;
        $site_themes = \DB::table('site_themes')->where('id',$id)->first();
        $cssContent  = $this->getFileContent(public_path('dynamic_css.txt'));
        $content = str_replace('#FONT_FAMILY#', FONT_FAMILY[$site_themes->body_font_family], $cssContent);
        $content = str_replace('#HEADER_COLOR#', $site_themes->header_color, $content);
        $content = str_replace('#PRIMARY_BUTTON_COLOR#', $site_themes->primary_button_color, $content);
        $content = str_replace('#SECONDARY_BUTTON_COLOR#', $site_themes->secondary_button_color, $content);
        $content = str_replace('#FOOTER_COLOR#', $site_themes->footer_color, $content);
        $content = str_replace('#SEARCH_BUTTON_COLOR#', $site_themes->search_button_color, $content);
        $content = str_replace('#FONT_SIZE#', $site_themes->body_text_size.'px', $content);
        $fpWrtie= fopen(public_path("css/site_theme.css"), "w");
        fwrite($fpWrtie, $content);
        
        \DB::table('site_themes')->update(array('status' => 0));
        $partner        = SiteTheme::where('id', $id)->get()->first();
        $new['status']  = 1;
        SiteTheme::where('id', $id)->update($new);
        if($new['status'] == 1) {
            \Artisan::call('cache:clear');
            Session::flash('flash_success', 'Theme has been Applied successfully'); 
        }else {
            Session::flash('flash_success', 'Theme has been Unpublished successfully'); 
        } 
        echo "success";
    }
    
    /**
     *  Partner Publish the Item
     * 
     */

    public function publishConfiguration(Request $request){
        $id = $request->id;
        
        \DB::table('site_configurations')->update(array('status' => 0));
        $new['status'] = 1;
        Configuration::where('id', $id)->update($new);
        $configuration = Configuration::where('id',$id)->first();
        
        if($configuration->id == 1){
            $source = public_path('images/logos/favicon.ico');  
        }else{
            $source = public_path('uploads/logo/').$configuration->favi_icon;  
        }
        // Store the path of destination file 
        $destination = public_path().'/favicon.ico';  
        copy($source, $destination);
        \Artisan::call('cache:clear');
        
        if($new['status'] == 1) {
            \Artisan::call('cache:clear');
            Session::flash('flash_success', 'Configuration has been Applied successfully'); 
        }else {
            Session::flash('flash_success', 'Configuration has been Unpublished successfully'); 
        } 
        echo "success";
    }
    
    /**
     *  
     *  Add setting
     */

    public function add(){
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'theming');
        Session::put('menu_item_child_child', '');
       
        $detail = "";
        $data = array('detail');
        
        return view('admin.settings.add', compact($data));        
    }
    /**
     *  
     *  Add configuration
     * 
     */

    public function addConfiguration($id=null){
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'configuration');
        Session::put('menu_item_child_child', '');
        $detail = "";

        if($id != null){
            $detail = Configuration::where('id',$id)->first();
            if(!$detail){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
        }
        $data = array('detail','id');        
        return view('admin.settings.configuration', compact($data));        
    }

     /**
     *  
     *  Edit configuration
     */

    public function edit($id){
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'theming');
        Session::put('menu_item_child_child', '');

        $detail = SiteTheme::where('id', $id)->get()->first();
        if(!$detail){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $data = array('id', 'detail');

        return view('admin.settings.add', compact($data));
    }


    /**
     *  Update theme
     * 
     */
    public function update(Request $request) {
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'theming');
        Session::put('menu_item_child_child', '');

        if($request->input('id')) {
            $id     = $request->input('id');
            $data   = $request->all();
            unset($data['id']);
            SiteTheme::find($id)->update($data); 
            Session::flash('flash_success', 'Theme has been updated successfully');           
        } else {
            $data           = $request->all();
            $insertedData   = SiteTheme::create($data);
            $id             = $insertedData->id;
            Session::flash('flash_success', 'Theme has been added successfully');    
        }
        return "success";

    }
    
    /**
     *  Update Configuration
     * 
     */
    public function configurationUpdate(Request $request) {
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'configuration');
        Session::put('menu_item_child_child', '');

        if($request->input('id')) {
            $id     = $request->input('id');
            $data   = $request->all();
            unset($data['id']);
            Configuration::find($id)->update($data); 
            
            Session::flash('flash_success', 'Configuration has been updated successfully');           
        }else{
            $data = $request->all();
            unset($data['id']);
            if (!$request->hasFile('logo')) {
                return "Logo is required";
            }
            if (!$request->hasFile('favi_icon')) {
                return "Favi icon is required";
            }
            if (!$request->hasFile('footer_logo')) {
                return "Footer logo is required";
            }
            $conf = Configuration::create($data); 
            $id = $conf->id;
            Session::flash('flash_success', 'Configuration has been added successfully');          
        }
        if ($request->hasFile('logo')) {
            $this->upload_attach($request, $id,'logo');
        }
        if ($request->hasFile('favi_icon')) {
            $this->upload_attach($request, $id,'favi_icon');
        }
        if ($request->hasFile('footer_logo')) {
            $this->upload_attach($request, $id,'footer_logo');
        }
        
        return "success";
    }

    /**
     *  
     *  Upload the Image
     */

    public function upload_attach(Request $request, $id,$field) {
            $getfiles   = $request->file($field);
            $extension  =  $getfiles->getClientOriginalExtension();
           
            if (!file_exists('uploads/logo')) {
                mkdir('uploads/logo', 0777, true);
            }
            $fileName = $id.'_'.$field.'.'.$extension;              
            //image compress start
            $getfiles->move(public_path('uploads/logo'), $fileName);
            Configuration::find($id)->update([$field => $fileName]);
            $configuration = Configuration::where('id',$id)->first();

            if($configuration->status == 1 && $field == "favi_icon"){
                $source = public_path('uploads/logo/').$fileName;  
                // Store the path of destination file 
                $destination = public_path().'/favicon.ico';  
                copy($source, $destination);
                \Artisan::call('cache:clear');
            }
            return "true";
    }

    /**
     *  
     *  Delete theme
     */

    public function delete(Request $request) {
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'theming');
        Session::put('menu_item_child_child', '');
        $id = $request->id;
        $data = SiteTheme::find($id); 
        if($data->status == 1){
            Session::flash('flash_success', 'Theme cannot be deleted, because its applied theme.'); 
        }else{
            $board = SiteTheme::where('id', $id)->delete(); 
            Session::flash('flash_success', 'Theme has been deleted successfully'); 

        }
        return "success";       
    }

    /**
     *  
     *  Delete configuration
     */

    public function deleteConfiguration(Request $request) {
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'configuration');
        Session::put('menu_item_child_child', '');

        $id     = $request->id;
        $data   = Configuration::find($id);
        if(!$data){
            Session::flash('flash_error', 'Record you are looking to delete is not found or already deleted.');
            return back();
        } 
        if($data->status == 1){
            Session::flash('flash_success', 'Configuration cannot be deleted, because its applied theme.'); 
        }else{
            $board = Configuration::where('id', $id)->delete(); 
            Session::flash('flash_success', 'Configuration has been deleted successfully'); 

        }
        return "success";       
    }

    /**
     * 
     *  Get file content
     * 
     */
    function getFileContent($filepath) {
        if(file_exists($filepath)) {
            $handle =fopen($filepath,"r");
            $contents = fread($handle, filesize($filepath));
            fclose($handle);
            return $contents;
        }	
    }

    /**
     * 
     *  Reset configuration
     * 
     */
    function resetConfiguration(Request $request)
    {
        \DB::table('site_configurations')->update(array('status' => 0));
        $new['status'] = 1;
        Configuration::where('id', 1)->update($new);
        $source = public_path('images/logos/favicon.ico');  
        
        // Store the path of destination file 
        $destination = public_path().'/favicon.ico';  
        copy($source, $destination);
        \Artisan::call('cache:clear');
   
        Session::flash('flash_success', 'Site Configuration has been reset to default successfully'); 
        
        return redirect(route('admin.settings.configuration_list'));
    }

    /**
     * *  Reset Default Theme
     * 
     */

    public function resetTheme(Request $request){
       
        $site_themes = \DB::table('site_themes')->where('id',1)->first();
        $cssContent = $this->getFileContent(public_path('dynamic_css.txt'));

        $content = str_replace('#FONT_FAMILY#', FONT_FAMILY[$site_themes->body_font_family], $cssContent);
        $content = str_replace('#HEADER_COLOR#', $site_themes->header_color, $content);
        $content = str_replace('#PRIMARY_BUTTON_COLOR#', $site_themes->primary_button_color, $content);
        $content = str_replace('#SECONDARY_BUTTON_COLOR#', $site_themes->secondary_button_color, $content);
        $content = str_replace('#FOOTER_COLOR#', $site_themes->footer_color, $content);
        $content = str_replace('#SEARCH_BUTTON_COLOR#', $site_themes->search_button_color, $content);
        $content = str_replace('#FONT_SIZE#', $site_themes->body_text_size.'px', $content);
        $fpWrtie= fopen(public_path("css/site_theme.css"), "w");
        fwrite($fpWrtie, $content);
        
        \DB::table('site_themes')->update(array('status' => 0));
        $new['status'] = 1;
        SiteTheme::where('id', 1)->update($new);
        \Artisan::call('cache:clear');
        Session::flash('flash_success', 'Theme has been reset to default successfully'); 
        return redirect(route('admin.settings.theming'));        
    }

    /**
     *  View Default Theme
     * 
     */

    public function viewTheme(Request $request){       
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'theming');
        Session::put('menu_item_child_child', '');

        $detail = SiteTheme::where('id', 1)->get()->first();
        $data = array( 'detail');

        return view('admin.settings.view_theme', compact($data));
        
    }
    /**
     *  View Default Theme
     * 
     */

    public function viewConfiguration(Request $request){       
        Session::put('menu_item_parent', 'settings');
        Session::put('menu_item_child', 'theming');
        Session::put('menu_item_child_child', '');

        $detail = Configuration::where('id', 1)->get()->first();
        $data = array( 'detail');

        return view('admin.settings.view_configuration', compact($data));
        
    }
}
