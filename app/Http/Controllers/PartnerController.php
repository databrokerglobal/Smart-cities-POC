<?php
/**
 *  
 *  Partner Controller
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
use App\Models\Partner;
use Session;
use App\Helper\SiteHelper;
use Image;

class PartnerController extends Controller
{
    /**
     *  
     *   List page
     */

    public function list(Request $request){
        Session::put('menu_item_parent', 'partners');
        Session::put('menu_item_child', 'partners');
        Session::put('menu_item_child_child', '');
        $partners = Partner::orderby('created_at', 'desc')
                            ->get();
       
          
        $data = array('partners');
        return view('admin.partners.list', compact($data));
    }

    /**
     * 
     *  Partner Publish the Item 
     * 
     */

    public function publish(Request $request){
        $id             = $request->id;
        $partner        = Partner::where('id', $id)->get()->first();
        $new['status']  = 1 - $partner->status;
        Partner::where('id', $id)->update($new);
        if($new['status'] == 1) {
            Session::flash('flash_success', 'Partner has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Partner has been Unpublished successfully'); 
        } 
        echo "success";
    }
    
    /**
     *  Partner Publish the proud partner
     * 
     */

    public function proudPartner(Request $request){
        $id                     = $request->id;
        $partner                = Partner::where('id', $id)->get()->first();
        $new['proud_partner']   = 1 - $partner->proud_partner;
        if($new['proud_partner'] == 1) {
            Session::flash('flash_success', 'Partner has been added as proud partners successfully'); 
            $count = Partner::where('proud_partner', 1)->count();
                if($count >= 6){
                    Session::flash('flash_success', 'Already maximum number of partners added in proud partners list, please remove any partner and try again.'); 
                }else{
                    Session::flash('flash_success', 'Partner has been added as proud partners successfully.');
                    Partner::where('id', $id)->update($new);
                }
        }else {
            Partner::where('id', $id)->update($new);
            Session::flash('flash_success', 'Partner has been removed from proud partners successfully'); 
        } 
        echo "success";
    }

    /**
     *  
     *  Add partner page
     * 
     */

    public function add(){
        Session::put('menu_item_parent', 'partners');
        Session::put('menu_item_child', 'partners');
        Session::put('menu_item_child_child', '');

        $detail     = "";
        $data       = array('detail');        
        return view('admin.partners.add', compact($data));
    }

    /**
     *  
     *  Edit partner page
     * 
     */

    public function edit($id){
        Session::put('menu_item_parent', 'partners');
        Session::put('menu_item_child', 'partners');
        Session::put('menu_item_child_child', '');

        $detail     = Partner::where('id', $id)->get()->first();
        if(!$detail){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $data       = array('id', 'detail');
        return view('admin.partners.add', compact($data));
    }

    /**
     *  Update partner page
     * 
     * 
     */
    public function update(Request $request) {
        Session::put('menu_item_parent', 'partners');
        Session::put('menu_item_child', 'partners');
        Session::put('menu_item_child_child', '');

        if($request->input('id')) {
            $id     = $request->input('id');
            $data   = $request->all();
            unset($data['id']);
            unset($data['files']);
            Partner::find($id)->update($data); 
            Session::flash('flash_success', 'Partner has been updated successfully');           
        } else {
            $data = $request->all();
            unset($data['files']);
            $insertedData = Partner::create($data);
            $id = $insertedData->id;
            Session::flash('flash_success', 'Partner has been added successfully');    
        }
        if ($request->hasFile('uploadedFile')) {
            $this->upload_attach($request, $id);            
        }        
        return "success";
    }

    /**
     *  
     *  Upload the partner Image
     * 
     */
    public function upload_attach(Request $request, $id) {
            $getfiles = $request->file('uploadedFile');
            if (!file_exists('uploads/partners')) {
                mkdir('uploads/partners', 0777, true);
                mkdir('uploads/partners/large', 0777, true);
                mkdir('uploads/partners/medium', 0777, true);
                mkdir('uploads/partners/tiny', 0777, true);
                mkdir('uploads/partners/thumb', 0777, true);
            }
            $fileName = $id.'.jpg';              
            SiteHelper::resizeAndUploadImage($getfiles,'PARTNERS', $fileName); 
          
            Partner::find($id)->update(['logo' => $fileName]);
            return "true";
    }
    /**
     *  
     *  Delete partner
     * 
     */
    public function delete(Request $request) {
        Session::put('menu_item_parent', 'partners');
        Session::put('menu_item_child', 'partners');
        Session::put('menu_item_child_child', '');
        $id     = $request->id;
        $board  = Partner::where('id', $id)->delete(); 
        Session::flash('flash_success', 'Partner has been deleted successfully'); 
        return "success";       
    }

   
}
