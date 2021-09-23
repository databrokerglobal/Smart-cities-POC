@extends('layouts.app')

@section('title', 'My Data Users | Databroker')
@section('description', '')

@section('additional_css')    
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <style>
        .user-data{
            margin-right: -5px;
        }
    </style>
@endsection

@include('modals/private_share')
@section('content')
<div class="container-fl.uid app-wapper myaccount">
    <div class="bg-pattern1-left"></div>
	<div class="app-section app-reveal-section align-items-center">	    
		<div class="container blog-header">
            <h2><b>{{ trans('pages.MY_DATA_USERS_TITLE')}}</b></h2>
            <p>{{ trans('pages.MY_DATA_USERS_PAGE_CONTENT')}}</p>

            <button type="button" class="btn btn-next customize-btn" data-toggle="modal" data-target="#addOrgModal">{{ trans('pages.NEW_ORGANIZATION') }}</button>
            <!-- <a href="{{ route('data_offer_start') }}"><button type="button" data-toggle="modal" data-target="#addOrgModal"
             class="customize-btn btn-next btn-sm">{{ trans('pages.NEW_ORGANIZATION') }}</button></a> -->
            
            <div class="container my-4">
                    
                <div class="table-responsive">
                    <table class="table collapsetable ">
                    <thead>
                        <tr>
                            <th scope="col"><b>Organization</b></th>
                            <th scope="col"><b>Data Products</b></th>
                            <th scope="col"><b>Status</b></th>
                            <th scope="col"><b>Action</b></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($sharingOrganisations as $key => $organization)

                            <tr >
                                <td  class="accordion-toggle collapsed colspan3" 
                                    id="accordion<?=$key?>" data-toggle="collapse" data-parent="#accordion<?=$key?>" 
                                        href="#collapse<?=$key?>" >
                                        <span class='expand-button'></span>{{$organization->orgName}} ({{count($organization->org_users)}})</td>
                                <td class='colspan3' >{{$organization->total_product_shares}}</td>
                                <td class='colspan3'>
                                    @if($organization->isActive == true)
                                        <div class='dot active-dot'></div>
                                    @else
                                        <div class='dot pending-dot'></div>
                                    @endif
                                </td>
                                <td class='colspan3'>
                                        <a title="delete organization" onclick="deleteOrganization(&quot;<?=$organization->orgIdx?>&quot;)" >
                                            <i class="icon material-icons mdl-badge my-icon">highlight_off</i>
                                        </a>
                                        <a title="edit organization" onclick="editOrgationazation(&quot;<?=$organization->orgIdx?>&quot;,&quot;<?=$organization->orgName?>&quot;)">
                                            <i class="icon material-icons mdl-badge my-icon">edit</i>
                                        </a>
                                        <a  title="add user" onclick="inviteUser(&quot;<?=$organization->orgIdx?>&quot;)">
                                            <i class="icon material-icons mdl-badge my-icon">person_add</i>
                                        </a>
                                        <a  onclick="sahreDataProducts(&quot;<?=$organization->orgIdx?>&quot;,'org')">
                                            <i class="icon material-icons mdl-badge my-icon">storage</i>
                                        </a>
                                </td>

                            </tr>
                             <tr class="hide-table-padding">
                                    <!-- <td></td> -->
                                    <td colspan="4 ">
                                    <div id="collapse<?=$key?>" class="collapse in p-3">
                                    @foreach ($organization->org_users as $user)
                                        <div class="row user-data">
                                            <div class="col-3">{{$user->orgUserEmail}}</div>
                                            <div class="col-3"><a href="joavascript:void(0)">{{$user->product_shares}}</a></div>
                                            <div class="col-3">
                                                @if($user->isUserRegistered == true)
                                                    <div class='dot active-dot'></div>
                                                @else
                                                    <div class='dot pending-dot'></div>
                                                @endif
                                            </div>
                                            <div class="col-3">
                                                <a title="delete user" onclick="deleteOrgUser(&quot;<?=$user->orgUserIdx?>&quot;)" >
                                                    <i class="icon material-icons mdl-badge my-icon">highlight_off</i>
                                                </a>
                                                <a title="edit user" onclick="editUser(&quot;<?=$organization->orgIdx?>&quot;,&quot;<?=$user->orgUserIdx?>&quot;,&quot;<?=$user->orgUserEmail?>&quot;)">
                                                    <i class="icon material-icons mdl-badge my-icon">edit</i>
                                                </a>
                                                <a  title="resend invitation" onclick="resendInvitation(&quot;<?=$user->orgUserIdx?>&quot;)">
                                                    <i class="icon material-icons mdl-badge my-icon">email</i>
                                                </a>
                                                <a  onclick="sahreDataProducts(&quot;<?=$user->orgUserIdx?>&quot;,'pro')">
                                                    <i class="icon material-icons mdl-badge my-icon">storage</i>
                                                </a>    
                                            </div>
                                        </div>
                                    @endforeach
                                </td>
                        </tr> 
                       
                    @endforeach
                    
                    
                        </tbody>
                    </table>
                    </div>
            
        </div>
          
            
		</div>
	</div>
</div>

@endsection
<script>
       
</script>
