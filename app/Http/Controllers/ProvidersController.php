<?php
/**
 *  
 *  Provider Controller
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
use App\Models\Theme;
use App\Models\Offer;
use App\Models\Provider;
use Session;
use App\Helper\SiteHelper;
use App\Models\Region;
use Image;

class ProvidersController extends Controller
{
    /**
     *  
     *   List page
     */

    public function list(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'providers');
        Session::put('menu_item_child_child', '');
        $providers = Provider::orderby('created_at', 'desc')
                            ->get();
       
          
        $data = array('providers');
        return view('admin.providers.list', compact($data));
    }

    /**
     *  Publish/Unpublish provider
     * 
     */

    public function publish(Request $request){
        $providerIdx    = $request->providerIdx;
        $provider       = Provider::where('providerIdx', $providerIdx)->get()->first();
        $new['status']  = 1 - $provider->status;
        if($new['status'] == 0 && $this->checkforLinkedProvider($providerIdx) === true){
            Session::flash('flash_success', 'Selected Provider is linked with other items. It cannot be unpublished.'); 
            return "success";            
        }
        Provider::where('providerIdx', $providerIdx)->update($new);
        if($new['status'] == 1) {
            Session::flash('flash_success', 'Provider has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Provider has been Unpublished successfully'); 
        } 
        echo "success";
    }

    /**
     *  
     *  Add Provider page
     */

    public function add(){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'providers');
        Session::put('menu_item_child_child', '');       
        $detail     = "";
        $data       = array('detail');        
        return view('admin.providers.add', compact($data));        
    }

    /**
     *  
     *  Edit Provider
     */

    public function edit($id){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'providers');
        Session::put('menu_item_child_child', '');

        $detail     = Provider::with('user','region')->where('providerIdx', $id)->get()->first();
        if(!$detail){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $regions    = Region::pluck('regionName','regionIdx')->toArray();
        $data       = array('id', 'detail', 'regions');
        return view('admin.providers.add', compact($data));
    }
    /**
     *  Update provider detail
     * 
     */
    public function update(Request $request) {       
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'providers');
        Session::put('menu_item_child_child', '');
        if($request->input('providerIdx')) {
            $id     = $request->input('providerIdx');
            $data   = $request->all();
            unset($data['providerIdx']);
            unset($data['files']);
            $slug       = SiteHelper::slugify($request->providerName);
            $slugCount  = Provider::where('slug', $slug)->where('providerIdx', '!=', $id)->count();
            if ($slugCount > 0) {
                $slug = $slug. '-'.$id;
            }
            $data['slug'] =  $slug;
            Provider::find($id)->update($data); 
            Session::flash('flash_success', 'Provider has been updated successfully');           
        } else {
            $data   = $request->all();
            unset($data['files']);
            $slug           = SiteHelper::slugify($request->providerName);
            $slugCount      = Provider::where('slug', $slug)->count();
            $insertedData   = Provider::create($data);
            $id             = $insertedData->providerIdx;
            if ($slugCount > 0) {
                $data           = [];              
                $data['slug']   =  $slug.'-'.$id;
                Provider::find($id)->update($data);
            }            
            Session::flash('flash_success', 'Provider has been added successfully');    
        }
        if ($request->hasFile('uploadedFile')) {
            $this->upload_attach($request, $id);            
        }        
        return "success";
    }

    /**
     *  
     *  upload the Image
     */

    public function upload_attach(Request $request, $id) {
            $getfiles = $request->file('uploadedFile');
            if (!file_exists('uploads/company')) {
                mkdir('uploads/company', 0777, true);
                mkdir('uploads/company/large', 0777, true);
                mkdir('uploads/company/medium', 0777, true);
                mkdir('uploads/company/tiny', 0777, true);
                mkdir('uploads/company/thumb', 0777, true);
            }
            $fileName = 'company_'.$id.'.jpg';    
            SiteHelper::resizeAndUploadImage($getfiles,'COMPANY', $fileName);           
            Provider::find($id)->update(['companyLogo' => $fileName]);
            return "true";
    }

    /**
     *  
     *  Delete provider
     */

    public function delete(Request $request) {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'providers');
        Session::put('menu_item_child_child', '');
        $providerIdx = $request->id;
        if($this->checkforLinkedProvider($providerIdx) === true){
            Session::flash('flash_success', 'Selected Provider is linked with other items. It cannot be deleted.'); 
            return "error";
        }else{
            $board = Provider::where('providerIdx', $providerIdx)->delete(); 
            Session::flash('flash_success', 'Provider has been deleted successfully'); 
            return "success";
        }       
    }

    /**
     *  
     *  Check whether provider is linked with any item or not
     */
    function checkforLinkedProvider($providerIdx){
        $ifUsed = Offer::where('providerIdx',$providerIdx)->first();
        if($ifUsed){
            return true;
        }
        return false;
    }
}
