
<!-- add organization modala start -->
<div class="modal fade" id="addOrgModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h4>Add Organization</h4>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf             
            <input type='hidden' id='fromPage' name="fromPage" value="" >
            <p class="add-org-feedback text-center" style="display: none">Organization added successfully.</p>
            <div class="email_lists cat-body">
                <div class="error_notice">Please add organization.</div>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="orgName" name="orgName" class="form-control2 input_data" placeholder=" "  required value="">
                    <span>Organization Name</span>                    
                    <div class="error_notice">Enter organization name.</div>
                </label>                               
            </div>         
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn addorg">Add</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- add organization modala end -->

<!-- edit organization modala start -->
<div class="modal fade" id="editOrgModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h4>Edit Organization</h4>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf
            <input type="hidden" name="orgIdx" id='orgIdx' value="">
             
            <p class="add-org-feedback text-center" style="display: none">Organization updated successfully.</p>
            <div class="email_lists cat-body">
                <div class="error_notice">Please add organization.</div>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="editOrgName" name="orgName" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Organization Name</span>                    
                    <div class="error_notice">Enter organization name.</div>
                </label>
                               
            </div>
         
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn editorg">Update</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- edit organization modala end -->

<!-- add new user for organization modala start -->
<div class="modal fade" id="inviteUserOrg" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h4 class='modal-title'>Create new user</h4>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf
            <input type="hidden" name="orgIdx" id='inviteorgIdx' value="">
            <input type="hidden" name="from" id='invitePage' value="">
            <input type="hidden" name="productIdx" id='inviteProductIdx' value="">
             
            <p class="add-org-user-feedback text-center" style="display: none">User Invited successfully.</p>
            <p class="add-org-user-error text-center" style="display: none">User already exists.</p><!-- if user exists -->
            <div class="email_lists cat-body">
                <div class="error_notice">Please enter user email .</div>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="orgUserEmail" name="orgUserEmail" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email Address</span>                    
                    <div class="error_notice">Enter email address.</div>
                </label>                               
            </div>

            <div class="row mgt10">
	            		<div class="col-lg-12">
			                
				        	<div class="radio-wrapper offerType">	
				        		<div class="mb-10">	                    
				                    <label class="container">
                              <span class='label-content'>Send an automatic registration invite to the user to validate his account.</span>
									  <input type="radio" name="sendAutomatic" checked=true value="automatic">
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="mb-10">
									<label class="container"> 
                    <span class='label-content'>Don't send an automatic invite. I'll do it myself using the following link</span>
									  <input type="radio" name="sendAutomatic" value="noautomatic">
									  <span class="checkmark"></span>
                  </label>
                  <br>
                  <a href="{{route('my_private_data_network')}}">{{ route('my_private_data_network') }}<a>	
								</div>
								
			        </div>
			                <span class="error_notice type"> Please select the offer type.</span>
						</div>
					</div>
         
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn inviteuser">Confirm</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- add new user for organization modala end -->


<!-- edit new user for organization modala start -->
<div class="modal fade" id="editInvitedOrgUser" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h4 class='modal-title'>Edit user</h4>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf
            <input type="hidden" name="orgUserIdx" id='orgUserIdx' value="">
            <input type="hidden" name="orgIdx" id='editorgIdx' value="">
             
            <p class="edit-org-user-feedback text-center" style="display: none">User updated successfully.</p>
            <div class="email_lists cat-body">
                <div class="error_notice">Please enter user email .</div>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="editOrgUserEmail" name="orgUserEmail" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email Address</span>                    
                    <div class="error_notice">Enter email address.</div>
                </label>                               
            </div>

            <div class="row mgt10">
	            		<div class="col-lg-12">
			                
				        	<div class="radio-wrapper offerType">	
				        		<div class="mb-10">	                    
				                    <label class="container">
                              <span class='label-content' >Send an automatic registration invite to the user to validate his account.</span>
									  <input type="radio" name="sendAutomatic" checked=true value="automatic">
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="mb-10">
									<label class="container">
                    <span class='label-content' >Don't send an automatic invite. I'll do it myself using the following link</span>                                 
									  <input type="radio" name="sendAutomatic" value="noautomatic">
									  <span class="checkmark"></span>
									</label>
                  <br>
                  <a href="{{route('my_private_data_network')}}">{{ route('my_private_data_network') }}<a>	
								</div>
								
			        </div>
			                <span class="error_notice type"> Please select the offer type.</span>
						</div>
					</div>
         
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn editInviteduser">Update</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- edit new user for organization modala end -->

<!-- resend invitaiton modala start -->
<div class="modal fade" id="resendInvitation" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h4 class='modal-title'>Resend Invitation</h4>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf
            <input type="hidden" name="orgUserIdx" id='inviteUserIdx' value="">             
            <p class="edit-org-user-feedback text-center" style="display: none">Invitation sent successfully.</p>  
            <p class="text-center" id="linkcopied" style="display: none">Link copied to clipboard.</p>        
            <div class="row mgt10">
	            		<div class="col-lg-12">
			                
				        	<div class="radio-wrapper offerType">	
				        		<div class="mb-10">	                    
				                    <label class="container">Send an automatic registration invite to the user to validate his account. 
									  <input type="radio" name="sendAutomatic" id='sendAutomatic' onchange="inviteTypeChnage('automatic',this)" class="sendInviteAutomatic" checked=true value="automatic">
									  <span class="checkmark"></span>
									</label>
								</div>
								<div class="mb-10">
									<label class="container">Don't send an automatic invite. I'll do it myself using the following link : 
                                        <br>
                                        <a class="disable-link" href='javascript:void(0)'>{{ route('my_private_data_network') }}<a>	
									  <input type="radio" onchange="inviteTypeChnage('manual',this)" name="sendAutomatic" class="sendInviteAutomatic" value="noautomatic">
									  <span class="checkmark"></span>
									</label>
								</div>
								
			        </div>
			                <span class="error_notice type"> Please select the offer type.</span>
						</div>
					</div>
         
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn resendInvite" id='resend_automatic'>Send Invite</button>
        <button type="button" class="button primary-btn" onclick="copyInviteLink(&quot;<?=route('my_private_data_network')?>&quot;,this)" id='resend_manula' style='display:none'>Copy The Link</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- resend invitation  modala end -->

<!-- show confirm box satart -->
<div class="modal fade" id="confirmBox" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h4 class='modal-title'>Confirmation</h4>  
      <input type='hidden' id='confirmingFrom' vlaue=''>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <div class="modal-body">
            <p>No users have been created yet, do you want to do it now?</p> 
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn " onclick="showAddOrg()">Yes</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">I'll do it later</button>
      </div>
    </div>
  </div>
</div>
<!-- show confirm box end -->

<!-- add users to data product start -->
<div class="modal fade" id="selectUserModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h6 class='modal-title'>Select the users from your data user list.</h6>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <div class="modal-body">
            
            <table class="table collapsetable ">
                    <thead>
                        <tr>
                            <th scope="col"><b>Organization</b></th>                            
                        </tr>
                    </thead> 
                    <tbody id='org_list'>
                        

                    </tbody>
            </table>
      </div>            
     <!--  <div class="modal-footer">        
        <button type="button" class="button primary-btn " onclick="showAddOrg()">Yes</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">I'll do it later</button>
      </div> -->
    </div>
  </div>
</div>
<!-- add users to data product end -->



<!-- add users to data product detail page start -->
<div class="modal fade" id="selectUserForProductModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
      <h6 class='modal-title'>Select the users from your data user list.</h6>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <form action="post" post autocomplete="off">
        @csrf
        <p class="invite-users-feedback text-center" style="display: none">Users invited successfully.</p>
        <input type='hidden' id='selected_users' name='selected_users'>
        <input type='hidden' id='selected_productIdx' name='productIdx'>
        <div class="modal-body">
              
              <table class="table collapsetable ">
                      <thead>
                          <tr>
                              <th scope="col"><b>Organization</b></th>                            
                          </tr>
                      </thead> 
                      <tbody id='org_user_list'>
                          

                      </tbody>
              </table>
        </div>   
      </form>         
      <div class="modal-footer">        
        <button type="button" class="button primary-btn inviteUsers" >Map Selected Users</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
<!-- add users to data product detail page end -->


<!-- share data products start -->
<div class="modal fade" id="shareDataProdcuts" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content modal-share-data">
      <div class="modal-header">        
      <h6 class='modal-title'>Share data products</h6>  
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>          
        </button>
        
      </div>
      <form action="post" post autocomplete="off">
            @csrf
            <input type='hidden' id='ShareProductOrgIdx' name='orgIdx' value="">
            <input type='hidden' id='ShareProductOrgUserIdx' name='orgUserIdx' value="">
          <p class="share-product-feedback text-center" style="display: none">Data products shared successfully.</p>
          <p class="share-product-error-feedback text-center" style="display: none">Please select atleast one product.</p>
          <div class="modal-body">
                
                  <table class="table collapsetable ">
                          <thead>
                              <tr>
                                  <th scope="col"><b>Offers</b></th>                            
                              </tr>
                          </thead> 
                          <tbody id='products_list'>                              
                          </tbody>
                  </table>            
          </div> 
          <input type='hidden' id='selected_products'  name='selected_products' value="">
        </form>           
       <div class="modal-footer">        
          <button type="button" class="button primary-btn shareUsers" >Share</button>
          <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
        </div>
      
    </div>
  </div>
</div>
<!-- share data products end -->