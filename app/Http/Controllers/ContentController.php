<?php
/**
 *  
 *  Content Controller
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
use Session;
use App\Models\Teams;
use App\Models\ContentStories;
use App\Models\ContentPages;
use App\Helper\SiteHelper;
use Image;

class ContentController extends Controller
{
     
    /**
     *  
     *  Edit page
     */

    public function editContent($id = 0){        
        Session::put('menu_item_parent', 'editcontent');
        if($id == 2)
            Session::put('menu_item_parent', 'editDxcDoc');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
      
        $content = ContentPages::where('contentIdx', $id)->get()->first();
        $stories = ContentStories::orderBy('created_at', 'desc')->get();
        $teams = Teams::orderBy('created_at', 'desc')->get();
        $data = array('id', 'content','stories','teams');
        
        return view('admin.content.edit', compact($data));
    }

    /**
     *   Delete Teams / Stories
     * 
     */

    public function deleteAction(Request $request){
        Session::put('menu_item_parent', 'editcontent');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        if($request->type == "stories"){
            ContentStories::where('storyIdx', $request->mid)->delete();
        }else  if($request->type == "team"){
            Teams::where('teamIdx', $request->mid)->delete();
        }       
        return "success";
    }
    
    /**
     *   Delete Teams / Stories
     * 
     */   

    public function publishAction(Request $request){
        Session::put('menu_item_parent', 'editcontent');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $record_idx = $request->record_idx;
        $name       = "";
        if($request->type == "stories"){
            $name           = "Story";
            $article        = ContentStories::where('storyIdx', $record_idx)->get()->first();
            $new['status']  = 1 - $article->status;
            ContentStories::where('storyIdx', $record_idx)->update($new);
        }else  if($request->type == "team"){
            $name           = "Team member";
            $article        = Teams::where('teamIdx', $record_idx)->get()->first();
            $new['status']  = 1 - $article->status;
            Teams::where('teamIdx', $record_idx)->update($new);
        }
       
        if($new['status'] == 1) {
            Session::flash('flash_success', $name.' has been Published successfully'); 
        }else {
            Session::flash('flash_success', $name.' has been Unpublished successfully'); 
        }        
        echo "success";
    }

    /**
     *  Store content
     *  
     * 
     */

    public function storeContent(Request $request){
        Session::put('menu_item_parent', 'editcontent');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        if($request->input('contentIdx')) {
            $id     = $request->input('contentIdx');
            $data   = $request->all();
            unset($data['contentIdx']);
            unset($data['files']);
            ContentPages::find($id)->update($data);
            Session::flash('flash_success', 'Content has been updated successfully'); 
            return "success";
        }
    }
    /**
     * 
     *  Store stories
     * 
     */
    public function storeStories(Request $request){
        Session::put('menu_item_parent', 'editcontent');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
      
        if($request->input('storyIdx') != null) {
            $id         = $request->input('storyIdx');
            $content_id = $request->input('content_id');
            $data       = $request->all();
            unset($data['storyIdx']);
            unset($data['files']);
            ContentStories::find($id)->update($data);
            Session::flash('flash_success', 'Story has been updated successfully'); 
            return ['status'=>"success",'content_id'=>$content_id];
        }else{
            $content_id     = $request->input('content_id');
            $data           = $request->all();
            unset($data['storyIdx']);
            unset($data['files']);
            ContentStories::create($data);
            Session::flash('flash_success', 'Story has been added successfully'); 
            return ['status'=>"success",'content_id'=>$content_id];
        }
    }

    /**
     * 
     * Store team
     * 
     */
    public function storeTeam(Request $request){
        Session::put('menu_item_parent', 'editcontent');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
      
        if($request->input('teamIdx') != null) {
            $teamIdx    = $request->input('teamIdx');
            $content_id = $request->input('content_id');
            $data       = $request->all();
            unset($data['teamIdx']);
            unset($data['files']);
            Teams::find($teamIdx)->update($data);
            Session::flash('flash_success', 'Team member has been updated successfully'); 
            
        }else{
            $content_id = $request->input('content_id');
            $data       = $request->all();
            unset($data['teamIdx']);
            unset($data['files']);
            $savedData  = Teams::create($data);
            $teamIdx    = $savedData->teamIdx;
            Session::flash('flash_success', 'Team member has been added successfully');            
        }
        if ($request->hasFile('uploadedFile')) {
            $this->upload_attach($request, $teamIdx);
            
        }
        return ['status'=>"success",'content_id'=>$content_id];
    }

    /**
     *  
     *  Upload the Image
     */

    public function upload_attach(Request $request, $teamIdx) {
            $getfiles = $request->file('uploadedFile');
            if (!file_exists('uploads/teams')) {
                mkdir('uploads/teams', 0777, true);
                mkdir('uploads/teams/large', 0777, true);
                mkdir('uploads/teams/medium', 0777, true);
                mkdir('uploads/teams/tiny', 0777, true);
                mkdir('uploads/teams/thumb', 0777, true);
            }
            $fileName = $teamIdx.'.jpg';      
            SiteHelper::resizeAndUploadImage($getfiles,'TEAMS',$fileName);         
            //image compress start
           
            Teams::find($teamIdx)->update(['pic' => $fileName]);
            return "true";
    }
    /**
     * 
     * Add stories
     * 
     */
    public function AddStories(Request $request,$id,$storyID=null){
        Session::put('menu_item_parent', 'editcontent');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');

        $story      = "";
        $content    = ContentPages::where('contentIdx', $id)->get()->first();
        if(!$content && $storyID == null){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        if($storyID != null){
            $story = ContentStories::where('storyIdx', $storyID)->get()->first();
            if(!$story){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
        }
        $data = array('content','storyID','story','id');
        return view('admin.content.addstories', compact($data));
    }
    /**
     *  Add team member
     * 
     * 
     */
    public function AddTeamMember(Request $request,$id,$memberID=null){
        Session::put('menu_item_parent', 'editcontent');
        Session::put('menu_item_child', '');
        Session::put('menu_item_child_child', '');
        $member     = "";
        $content    = ContentPages::where('contentIdx', $id)->get()->first();
        if(!$content && $memberID == null){
            Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
            return back();
        }
        if($memberID != null){
            $member = Teams::where('teamIdx', $memberID)->get()->first();
            if(!$member){
                Session::flash('flash_error', 'Record you are looking to edit is not found or deleted.');
                return back();
            }
        }
        $data = array('content','memberID','member','id');
        return view('admin.content.addteam', compact($data));
    }
}
