@extends('layouts.app')

@section('title', 'Account and profile info | Databroker')
@section('description', '')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection
@section('content')
<div class="container-fluid app-wapper profile">
    <div class="bg-pattern1-left"></div>
	<div class="app-section app-reveal-section align-items-center">	    
		<div class="container">
        @include('layouts.flash')
            <div class="blog-header">
                <h1>Account info</h1>
                <div class="label companyname1">
                    <span>Account name: </span>
                    <span class="adminname">{{$company->companyName}}</span>
                </div>
                <div class="label ">
                    <span>Administrator: </span>
                    <span class="adminname">{{$admin->firstname}} {{$admin->lastname}}</span>
                </div>
            </div>

            <div class="app-section profileinfo">
                <div id="profile-display-section">       
                    <div class="profile-section-header flex-vcenter-justify mb-10">                
                        <div class="sectiontitle">My profile</div>
                        <div id="edit-button" class="action-button-edit flex-center" onClick="document.getElementById('profile-edit-section').style.display = 'block';document.getElementById('profile-display-section').style.display = 'none';">
                            <i class="material-icons">edit</i> {{ trans('pages.edit') }}
                        </div>
                    </div>             
                    <div class="row">
                        <div class="col-2 info-label">{{ trans('pages.name') }}:</div>
                        <div class="col info-text">{{ $user->firstname }} {{ $user->lastname }}</div>
                    </div>

                    <div class="row">
                        <div class="col-2 info-label">{{ trans('pages.email_address') }}:</div>
                        <div class="col info-text">{{ $user->email }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 info-label">{{ trans('pages.job_title') }}:</div>
                        <div class="col info-text">{{ $user->jobTitle }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 info-label">{{ trans('pages.role') }}:</div>
                        <div class="col info-text">{{ $user->role }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 info-label">{{ trans('pages.industry') }}:</div>
                        <div class="col info-text">{{ $user->businessName }}</div>
                    </div>
                    <div class="row">
                        <div class="col-2 info-label">{{ trans('pages.Password') }}:</div>
                        <div class="col info-text">**************</div>
                    </div>
                </div><!--profile-display-section-->

                <div id="profile-edit-section" style="display: none;" >
                    <div id="cancel-button" class="top-right flex-center" onClick="document.getElementById('profile-edit-section').style.display = 'none';document.getElementById('profile-display-section').style.display = 'block';">
                       <i class="material-icons">close</i> Cancel
                    </div>
                    <br />
                    <form method="POST" action="{{ route('account.profile.update') }}" autocomplete="off">
                        @csrf

                        <label class="pure-material-textfield-outlined">
                            <input type="text" id="firstname" name="firstname" class="form-control input_data" placeholder=" "  value="{{ $user->firstname }}" autocomplete="firstname" autofocus>
                            <span>{{ trans('auth.first_name') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'First Name']) }}</div>
                            <span class="invalid-feedback firstname" role="alert">
                                <strong></strong>
                            </span>
                        </label>

                        <label class="pure-material-textfield-outlined">
                            <input type="text" id="lastname" name="lastname" class="form-control input_data" placeholder=" "  value="{{ $user->lastname }}" autocomplete="lastname" autofocus>
                            <span>{{ trans('auth.last_name') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Last Name']) }}</div>
                            <span class="invalid-feedback lastname" role="alert">
                                <strong></strong>
                            </span>
                        </label>
                        <label class="pure-material-textfield-outlined">
                            <input type="text" id="email" name="email" class="form-control input_data" placeholder=" " value="{{ $user->email }}" autofocus>
                            <span>{{ trans('auth.email_address') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Email Address']) }}</div>
                            <span class="invalid-feedback email" role="alert">
                                <strong></strong>
                            </span>
                        </label>

                        <div class="dropdown-container">
                            <div class="dropdown2 business_list" tabindex="1">                                
                                <div class="adv-combo-wrapper">
                                    <select id="businessName2" class="" name="businessName2" placeholder="Which industry are you in?">
                                        <option></option>
                                    @foreach ($businesses as $business)
                                        @if($user->businessName==$business->businessName)
                                        <option value="{{$business->businessName}}" selected>{{ $business->businessName }}</option>
                                        @else
                                        <option value="{{$business->businessName}}">{{ $business->businessName }}</option>
                                        @endif
                                    @endforeach
                                     </select>
                                </div>                              
                            </div>
                        </div>    

                        <label class="other-industry pure-material-textfield-outlined" style="display: none">
                            <input type="text" id="businessName" name="businessName" class="form-control input_data" placeholder=" " value="{{ $user->businessName }}" autocomplete="businessName" autofocus>
                            <span>{{ trans('auth.enter_your_industry') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Last Name']) }}</div>
                            <span class="invalid-feedback busienssName" role="alert">
                                <strong></strong>
                            </span>
                        </label>

                        <label class="pure-material-textfield-outlined">
                            <input type="text" id="jobTitle" name="jobTitle" class="form-control input_data" placeholder=" "  value="{{ $user->jobTitle }}" autocomplete="jobTitle" autofocus>
                            <span>{{ trans('auth.jobTitle') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Job title']) }}</div>
                            <span class="invalid-feedback jobTitle" role="alert">
                                <strong></strong>
                            </span>
                        </label>

                        <div class="dropdown-container">
                            <div class="dropdown2 role_list" tabindex="1">                                
                                <div class="adv-combo-wrapper">
                                    <select id="role2" name="role2" placeholder="What role do you have?">
                                        <option></option>
                                        @if($user->role=='Business')
                                        <option value="Business" selected>Business</option>
                                        @else
                                        <option value="Business">Business</option>
                                        @endif
                                        @if($user->role=='Technical')
                                        <option value="Technical" selected>Technical</option>
                                        @else
                                        <option value="Technical">Technical</option>
                                        @endif
                                        @if($user->role=='Other')
                                        <option value="Other" selected>Other</option>
                                        @else
                                        <option value="Other">Other</option>
                                        @endif
                                     </select>
                                    <span class="invalid-feedback role2" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>                              
                            </div>
                        </div>    

                        <label class="other-role pure-material-textfield-outlined" style="display: none">
                            <input type="text" id="role" name="role" class="form-control input_data" placeholder=" "  value="{{ $user->role }}" autocomplete="role" autofocus>
                            <span>{{ trans('auth.enter_your_role') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Role']) }}</div>
                            <span class="invalid-feedback role" role="alert">
                                <strong></strong>
                            </span>
                        </label>

                        <label class="pure-material-textfield-outlined">
                            <input type="password" id="oldPassword" name="oldPassword" class="form-control input_data" placeholder=" "  value="" autocomplete="oldPassword" autofocus>
                            <span>{{ trans('auth.old_password') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Old password']) }}</div>
                            <span class="invalid-feedback oldPassword" role="alert">
                                <strong></strong>
                            </span>
                        </label>

                        <label class="pure-material-textfield-outlined">
                            <input type="password" id="password" name="password" class="form-control input_data" placeholder=" "  value="" autocomplete="password" autofocus>
                            <span>{{ trans('auth.new_password') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Password']) }}</div>
                            <span class="feedback password" role="alert">
                                <strong>
                                    Your password must contain at least <span class="has8letters">8 characters</span>, including <span class="hasupperletter">1 uppercase letter</span> and <span class="hasdigit">1 digit</span>.
                                </strong>
                            </span>
                        </label>

                        <label class="pure-material-textfield-outlined">
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control input_data" placeholder=" "  value="" autocomplete="password_confirmation" autofocus>
                            <span>{{ trans('auth.confirm_password') }}</span>
                            <div class="error_notice">{{ trans('validation.required', ['attribute' => 'Confirm password']) }}</div>
                            <span class="feedback password_confirmation" role="alert">
                                <strong></strong>
                            </span>
                        </label>

                        <div class="row">
                            <div class="col info-text flex-vend">
                                <button type="submit" class="customize-btn">UPDATE PROFILE</button>
                            </div>
                        </div>
                    </form>
                </div><!--profile-edit-section-->

			</div><!--app-section profileinfo-->

			<div class="divider-green mgt30"></div>

			<div id="Group_2476" class="app-section users">
				<div class="sectiontitle">
					<span>Other users linked to this account</span>
				</div>
                @if(sizeof($users) >0 || sizeof($invited_users) >0)
				<table class="table">
				  <thead>
				    <tr>
				      <th scope="col" class="col-name"></th>
				      <th scope="col" class="col-since"></th>
				      <th scope="col" class="col-action"></th>
				    </tr>
				  </thead>
				  <tbody>                      
                    @foreach($users as $company_user)
				    <tr class="registered">
				      <td class="col-name">{{ $company_user->firstname }} {{ $company_user->lastname }} @if($company_user->userStatus == 1) (administrator) @endif</td>
				      <td class="col-since">{{ date('d/m/Y', strtotime($company_user->created_at)) }}</td>
                      @if($user->userStatus == 1)
				      <td class="col-action">
                        <a class="action-button-delete" data-toggle="modal" data-target="#deleteModal" user-id="{{ $company_user->userIdx }}">
                            <div class="flex-center justify-end color-gray5">
                                <i class="icon material-icons ">
                                    cancel
                                </i>                                
                                <span class="label-delete">{{ trans('pages.Delete') }}</span>
                            </div>
                        </a>
	    			  </td>
                      @endif
				    </tr>
                    @endforeach	

                    @foreach($invited_users as $invited_user)
                    <tr class="invited">
                      <td class="col-name">{{ $invited_user->linked_email }}</td>
                      <td class="col-since">Pending</td>
                      @if($user->userStatus == 1)
                      <td class="col-action">
                        <a class="action-button-delete" data-toggle="modal" data-target="#deleteModal" user-id="{{ $invited_user->linkedIdx }}">
                            <div class="flex-center justify-end color-gray5">
                                <i class="icon material-icons ">
                                    cancel
                                </i>                                
                                <span class="label-delete">{{ trans('pages.Delete') }}</span>
                            </div>
                        </a>
                      </td>
                      @endif
                    </tr>
                    @endforeach                 
				  </tbody>
				</table>
                @endif
                @if($user->userStatus == 1)
				<button type="button" id="inviteBtn" class="button secondary-btn mt-20" data-toggle="modal" data-target="#inviteModal">{{ trans('pages.INVITE_USERS') }}</button>
                @endif
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="post" post autocomplete="off">
            @csrf
            <input type="hidden" name="invite_userIdx" value="{{$user->userIdx}}">
            <p class="para">
                An email will be sent to these recipients, inviting them to register on {{APPLICATION_NAME}}
            </p>    
            <p class="invalid-feedback text-center" style="display: none">The email is successfully sent.</p>
            <div class="email_lists cat-body">
                <div class="error_notice">Please add email address.</div>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="email1" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email 1</span>                    
                    <div class="error_notice">Email format is incorrect.</div>
                    <div class="error_notice_limit">Email may not be greater than 100 characters.</div>
                </label>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="email2" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email 2</span> 
                    <div class="error_notice">Email format is incorrect.</div>    
                    <div class="error_notice_limit">Email may not be greater than 100 characters.</div>                    
                </label>
                <label class="pure-material-textfield-outlined">
                    <input type="email" id="email3" name="linked_email[]" class="form-control2 input_data" placeholder=" "  value="">
                    <span>Email 3</span> 
                    <div class="error_notice">Email format is incorrect.</div>   
                    <div class="error_notice_limit">Email may not be greater than 100 characters.</div>                     
                </label>                
            </div>
            <a class="more_email pull-right mb-20" href="javascript:;">+ more</a>
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn invite">Invite</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="unpublishModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">        
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="post" post>
            @csrf
            <input type="hidden" name="list_userIdx" value="">
            <input type="hidden" name="user_type" value="">
            <p class="para">
                Are you sure you want to delete this user?
            </p>                
        </form>        
      </div>            
      <div class="modal-footer">        
        <button type="button" class="button primary-btn confirm">Confirm</button>
        <button type="button" class="button secondary-btn" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('additional_javascript')    
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var path = window.location.search;
            console.log(path);
            if(path.split("?")[1]){
                var im = path.split("?")[1].split('=')[1];
                if(im==1) $("#inviteBtn").trigger('click');
            }
            $("input[name='password']").on("keyup", function(e){
                var has8letters = false;
                var hasupperletter = false;
                var hasdigit = false;
                var text = $(this).val();
                if(text.length >= 8) has8letters = true;
                else has8letters = false;
                if(text.length!=0){
                    for(var i=0; i<text.length; i++){
                        if(text[i]>='A' && text[i]<='Z')
                            hasupperletter = true;
                        if(text[i]>='0' && text[i]<='9')
                            hasdigit = true;
                    }
                }
                if(has8letters) $(this).siblings('.feedback').find('.has8letters').addClass('passed');
                else $(this).siblings('.feedback').find('.has8letters').removeClass('passed');
                if(hasupperletter) $(this).siblings('.feedback').find('.hasupperletter').addClass('passed');
                else $(this).siblings('.feedback').find('.hasupperletter').removeClass('passed');
                if(hasdigit) $(this).siblings('.feedback').find('.hasdigit').addClass('passed');
                else $(this).siblings('.feedback').find('.hasdigit').removeClass('passed');
                if(has8letters && hasupperletter && hasdigit) $(this).siblings('.feedback').addClass('text-green');
                else $(this).siblings('.feedback').removeClass('text-green');
            });
            $("input[name='password_confirmation']").on("keyup", function(e){
                var password = $("input[name='password']").val();
                var confirm = $(this).val();
                console.log(password.indexOf(confirm));
                if(confirm == password) {
                    $(this).siblings('.feedback').html("<strong class='text-green'>Passwords match.</strong>");
                }else if(password.indexOf(confirm)){
                    $(this).siblings('.feedback').html("<strong class='text-red'>Passwords do not match.</strong>");
                }else{
                    $(this).siblings('.feedback').html("<strong class='text-red'></strong>");
                }
            });
        })
    </script>
@endsection