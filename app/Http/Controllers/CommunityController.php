<?php
/**
 *  
 *  Community Controller
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
use App\Models\Article;
use App\Models\CommunityNewOffer;
use App\Models\CommunityDiscover;
use App\Models\Community;
use Session;
use App\Helper\SiteHelper;
use Image;

class CommunityController extends Controller
{
     /**
     *  
     *   List page
     */

    public function list(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $communities = Community::orderby('created_at', 'desc')
                            ->get();
       
          
        $data = array('communities');
        return view('admin.communities.list', compact($data));
    }

    /**
     *  Usecases Publish the Item
     * 
     */

    public function publish(Request $request){
        $communityIdx   = $request->communityIdx;
        $community      = Community::where('communityIdx', $communityIdx)->get()->first();
        $new['status']  = 1 - $community->status;
        if($new['status'] == 0 && $this->checkforLinkedComunity($communityIdx) === true){
            Session::flash('flash_success', 'Selected Community is linked with other items. It cannot be Unpublished.'); 
            return "success";
            
        }
        Community::where('communityIdx', $communityIdx)->update($new);
        if($new['status'] == 1) {
            Session::flash('flash_success', 'Community has been Published successfully'); 
        }else {
            Session::flash('flash_success', 'Community has been Unpublished successfully'); 
        } 
        echo "success";
    }

    /**
     *  
     *  Add
     */

    public function add(){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
       
        $detail = "";
        $data = array('detail');
        
        return view('admin.communities.add', compact($data));        
    }

    /**
     *  
     *  Edit
     */

    public function edit($id){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');

        $detail = Community::where('communityIdx', $id)->get()->first();
        if(!$detail){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $data   = array('id', 'detail');

        return view('admin.communities.add', compact($data));
    }


    /**
     *  update
     * 
     */
    public function update(Request $request){
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        if($request->input('communityIdx')) {
            $id     = $request->input('communityIdx');
            $data   = $request->all();
            unset($data['communityIdx']);
            unset($data['files']);
            $slug       = SiteHelper::slugify($request->communityName);            
            $slugCount  = Community::where('slug', $slug)->where('communityIdx', '!=', $id)->count();
            if ($slugCount > 0) {
                $slug = $slug. '-'.$id;
            }
            $data['slug'] =  $slug;

            Community::find($id)->update($data); 
            Session::flash('flash_success', 'Communitiy has been updated successfully');           
        } else {
            $data           = $request->all();
            unset($data['files']);            
            $slug           = SiteHelper::slugify($request->communityName);            
            $slugCount      = Community::where('slug', $slug)->count();
            $insertedData   = Community::create($data);            
            $id = $insertedData->communityIdx;
            if ($slugCount > 0) {                
                $data = [];              
                $data['slug'] =  $slug.'-'.$id;
                Community::find($id)->update($data);
            }else{
                $data['slug'] =  $slug;
                Community::find($id)->update($data);
            }
            
            Session::flash('flash_success', 'Communitiy has been added successfully');    
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
            if (!file_exists('uploads/communities')) {
                mkdir('uploads/communities', 0777, true);
                mkdir('uploads/communities/large', 0777, true);
                mkdir('uploads/communities/medium', 0777, true);
                mkdir('uploads/communities/tiny', 0777, true);
                mkdir('uploads/communities/thumb', 0777, true);
            }
            $fileName = $id.'.jpg';              
            SiteHelper::resizeAndUploadImage($getfiles,'COMMUNITIES',$fileName);      
            Community::find($id)->update(['image' => $fileName]);
            return "true";
    }    

    /**
     *  
     *  Delete
     */

    public function delete(Request $request) {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $communityIdx = $request->id;
        if($this->checkforLinkedComunity($communityIdx) === true){
            Session::flash('flash_success', 'Selected Community is linked with other items. It cannot be deleted.'); 
            return "error";
        } else {
            $board = Community::where('communityIdx', $communityIdx)->delete(); 
            Theme::where('communityIdx',$communityIdx)->delete(); 
            Session::flash('flash_success', 'Community has been deleted successfully'); 
            return "success";
        }       
    }

    /**
     * 
     *  Check for Linked community
     * 
     */
    function checkforLinkedComunity($communityIdx){
        $ifUsed = Theme::where('communityIdx',$communityIdx)->first();
        if($ifUsed){
           return true;
        } else {
            $ifUsed = Offer::where('communityIdx',$communityIdx)->first();
            if($ifUsed){
                return true;
            }else{
                $ifUsed = Article::where('communityIdx',$communityIdx)->first();
                if($ifUsed){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * Get Community Offers
     */
    public function getCommunityOffers($id)
    {
        return Offer::select('offerIdx', 'offerTitle')->where('communityIdx', $id)->where('status', 1)->get();
    }

    /**
     * List New data of communities
     */
    public function newDataToCommunity()
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $communitiesData = CommunityNewOffer::with(['community:communityIdx,communityName', 'offer:offerIdx,offerTitle,providerIdx'])->orderby('created_at', 'desc')
                            ->get();
       
          
        $data = array('communitiesData');
        return view('admin.communities.new_community_data', compact($data));
    }    

    /**
     * Add new data offers to community
     */
    public function addNewDataOfferToCommunity()
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $communities = Community::orderby('created_at', 'desc')
                            ->get();
        return view('admin.communities.add_new_to_community', compact('communities'));
    }

    /**
     * Edit new data offers to community
     */
    public function editNewDataOfferToCommunity($id)
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $detail = CommunityNewOffer::where('id', $id)->first();
        if(!$detail){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $communityOffers = Offer::select('offerIdx', 'offerTitle')->where('communityIdx', $detail->communityIdx)->where('status', 1)->get();
        $communities = Community::orderby('created_at', 'desc')
                            ->get();
        return view('admin.communities.add_new_to_community', compact('communities', 'detail', 'communityOffers', 'id'));
    }

    /**
     * Update offers new to community
     */
    public function updateNewDataofCommunity(Request $request)
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        if($request->input('communityNewDataIdx')) {
            $id     = $request->input('communityNewDataIdx');
            $data   = $request->all();
            unset($data['communityNewDataIdx']);
            CommunityNewOffer::find($id)->update($data); 
            Session::flash('flash_success', 'Communitiy new data has been updated successfully');           
        } else {
            $data   = $request->all();
            CommunityNewOffer::create($data);
            Session::flash('flash_success', 'Offer has been added in community as new data.');    
        }   
        return "success";
    }

    /**
     * Delete new data to community
     */
    public function deleteNewDataOfferToCommunity($id)
    {
        CommunityNewOffer::find($id)->delete();
        Session::flash('flash_success', 'Offer has been removed from community as new data.');
        return "true";
    }

    /**
     * List Discover data of communities
     */
    public function discoverDataOfCommunity()
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $communitiesData = CommunityDiscover::with(['community:communityIdx,communityName', 'offer:offerIdx,offerTitle,providerIdx'])->orderby('created_at', 'desc')
        ->get();
       
          
        $data = array('communitiesData');

        return view('admin.communities.discover_community_data', compact($data));
    }

    /**
     * Add new data offers to community
     */
    public function addDiscoverDataToCommunity()
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $communities = Community::orderby('created_at', 'desc')
                            ->get();
        return view('admin.communities.add_discover_data_community', compact('communities'));
    }

    /**
     * Edit new data offers to community
     */
    public function editDiscoverDataToCommunity($id)
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        $detail = CommunityDiscover::where('id', $id)->first();
        if(!$detail){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        $communityOffers = Offer::select('offerIdx', 'offerTitle')->where('communityIdx', $detail->communityIdx)->where('status', 1)->get();
        $communities = Community::orderby('created_at', 'desc')
                            ->get();
        return view('admin.communities.add_discover_data_community', compact('communities', 'detail', 'communityOffers', 'id'));
    }

    /**
     * Update offers new to community
     */
    public function updateDiscoverDataToCommunity(Request $request)
    {
        Session::put('menu_item_parent', 'content');
        Session::put('menu_item_child', 'communities');
        Session::put('menu_item_child_child', '');
        if($request->input('communityDiscoverIdx')) {
            $id     = $request->input('communityDiscoverIdx');
            $data   = $request->all();
            unset($data['files']);
            unset($data['communityDiscoverIdx']);
            CommunityDiscover::find($id)->update($data); 
            Session::flash('flash_success', 'Communitiy new data has been updated successfully');           
        } else {
            $data   = $request->all();
            unset($data['files']);
            $inserted = CommunityDiscover::create($data);
            $id = $inserted->id;
            Session::flash('flash_success', 'Communitiy new data has been added successfully');    
        }
        if ($request->hasFile('uploadedFileImage')) {
            $this->uploadDiscoverAttach($request, $id);            
        }   
        return "success";
    }

    /**
     * Delete new data to community
     */
    public function deleteDiscoverDataToCommunity($id)
    {
        $communityDiscover  = CommunityDiscover::find($id);
        if(!empty($communityDiscover->image)){
            if (file_exists( public_path() . '/uploads/communities/discover/' . $communityDiscover->image)) {
                unlink('uploads/communities/discover/'.$communityDiscover->image);
            }
            if (file_exists( public_path() . '/uploads/communities/discover/large/' . $communityDiscover->image)) {
                unlink('uploads/communities/discover/large/'.$communityDiscover->image);
            }
            if (file_exists( public_path() . '/uploads/communities/discover/medium/' . $communityDiscover->image)) {
                unlink('uploads/communities/discover/medium/'.$communityDiscover->image);
            }
            if (file_exists( public_path() . '/uploads/communities/discover/tiny/' . $communityDiscover->image)) {
                unlink('uploads/communities/discover/tiny/'.$communityDiscover->image);
            }
            if (file_exists( public_path() . '/uploads/communities/discover/thumb/' . $communityDiscover->image)) {
                unlink('uploads/communities/discover/thumb/'.$communityDiscover->image);
            }
        }
        $communityDiscover->delete();
        return "true";
    }

    /**
     *  
     *  upload the discover Image
     */

    public function uploadDiscoverAttach(Request $request, $id) {
        $getfiles = $request->file('uploadedFileImage');
        if (!file_exists('uploads/communities/discover')) {
            mkdir('uploads/communities/discover', 0777, true);
            mkdir('uploads/communities/discover/large', 0777, true);
            mkdir('uploads/communities/discover/medium', 0777, true);
            mkdir('uploads/communities/discover/tiny', 0777, true);
            mkdir('uploads/communities/discover/thumb', 0777, true);
        }
        $fileName = $id.'.jpg';              
        SiteHelper::resizeAndUploadImage($getfiles,'COMMUNITIES_DISCOVER',$fileName);      
        CommunityDiscover::find($id)->update(['image' => $fileName]);
        return "true";
    }
}
