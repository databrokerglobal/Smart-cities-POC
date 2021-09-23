@extends('layouts.app')

@section('title', $aboutus->title.' |  '.env("APP_NAME") )
@section('description', $aboutus->sub_title)

@section('content')
<div id="background-image-mobile"></div>
<div class="container-fluid app-wapper about">
    <div class="bg-pattern1-left"></div>
    <div class="container">
        <div class="app-section align-items-center">
            <div class="blog-header mgt60">
                <h1>{{$aboutus->title}}</h1>
                <div class="para">{{$aboutus->sub_title}}</div>
            </div>  
            <div class="divider-green mgt30"></div>
            {!!$aboutus->description!!}
        </div>  
    </div>
</div>

<div class="container-fluid app-wapper" id="container-responsive-about">
        <div class="section_splitor_green"></div>
        <div class="container">
            <div class="app-section flex-vcenter flex-vertical story-section">
                <div class="divider-green mgt30"></div>
                <div class="h2 section-title">Our story</div>
                <div class="history-container">
                    <div class="col-history-connectors-layer">
                        <div class="col-history-connectors">
                            <div class="history-connector-wrapper flex-vcenter flex-vertical">
                                <div class="history-connector solid"></div>
                                <div class="history-connector dot"></div>
                                <div class="history-connector arrow"></div>
                            </div>
                        </div>
                        <div class="history-node-wrapper col-mid-timeline">
                            <?php
                            $i = 2;
                            $Colorclass = [2=>'#06038D',3=>'#2643A0',4=>'#5097B8',5=>'#78E6D0'];
                            foreach($aboutus->stories as $stories){
                            if($i %2 == 0){
                                $class = "left";
                                ?>
                                 <div id="hn{{$stories->storyIdx}}" class="history-node <?php echo ($i == 2)?'big':'small'; ?> left <?php echo ($i != 2)?'margin_ty':''; ?>">
                                    <svg class="timeline <?php echo ($i == 2)?'big':'small'; ?>">
                                        <?php if($i == 2){ ?>
                                        <ellipse fill="rgba(255,255,255,1)" stroke="rgba(6,3,141,1)" stroke-width="5px" stroke-linejoin="miter" stroke-linecap="butt" stroke-miterlimit="4" shape-rendering="auto" rx="15" ry="15" cx="15" cy="15">
                                        </ellipse>           
                                        <?php } else{ ?>
                                            <ellipse fill="rgba(255,255,255,1)" stroke="<?php echo (isset($Colorclass[$i])?$Colorclass[$i]:$Colorclass[5]) ?>" stroke-width="5px" stroke-linejoin="miter" stroke-linecap="butt" stroke-miterlimit="4" shape-rendering="auto" rx="10" ry="10" cx="10" cy="10">
                                            </ellipse>  
                                            
                                        <?php } ?>
                                    </svg>
                                    <div class="history-line" style="border: 1.5px solid <?php echo (isset($Colorclass[$i])?$Colorclass[$i]:$Colorclass[5]) ?>;"></div>
                                    <div id="chb{{$stories->storyIdx}}" class="history-block ">
                                        <div class="h3 color-green" id="f-color-green">{{$stories->year}}</div>
                                        <div class="h1-small color-blue f" >{{$stories->title}}</div>
                                        <p class="para f">{!!nl2br($stories->description)!!}</p>
                                    </div>
                                </div>
                                <?php
                            }else{
                                $class = "right";
                                ?>
                                <div id="hn{{$stories->storyIdx}}" class="history-node small right margin_ty">
                                    <svg class="timeline small">
                                        <ellipse fill="rgba(255,255,255,1)" stroke="<?php echo (isset($Colorclass[$i])?$Colorclass[$i]:$Colorclass[5]) ?>" stroke-width="5px" stroke-linejoin="miter" stroke-linecap="butt" stroke-miterlimit="4" shape-rendering="auto" rx="10" ry="10" cx="10" cy="10">
                                        </ellipse>                            
                                    </svg>
                                    <div class="history-line" style="border: 1.5px solid <?php echo (isset($Colorclass[$i])?$Colorclass[$i]:$Colorclass[5]) ?>;"></div>
                                    <div id="chb{{$stories->storyIdx}}" class="history-block ">
                                        <div class="h3 color-green">{{$stories->year}}</div>
                                        <div class="h1-small color-blue s">{{$stories->title}}</div>
                                        <p class="para fo">{!!nl2br($stories->description)!!}</p>
                                    </div>
                                </div>
                                <?php
                            }    
                            ?>
                           
                            <?php $i++; } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<div class="sub-footer container-fluid app-wapper">
    <div class="container">
        <div class="blog-section">
            <div class="flex-vertical flex-vcenter">
                <div class="divider-green mgt60"></div>
                <div class="h2 mgb40">The team</div>
                <div class="teammembers row mgb40">
                    @foreach ($aboutus->teams as $member)
                    <div class="cell member col-lg-3 col-sm-6 col-xs-6 flex-vertical flex-vcenter text-center mgt40 mgb40">
                         <?php if($member->pic && file_exists(public_path('uploads/teams/thumb/'.$member->pic))) {
                            $pic =  asset('uploads/teams/'.$member->pic);
                         }
                        else {
                            $pic =  asset('images/gallery/thumbs/thumb/default.png');
                        }
                         ?>       
                            <div class="partner-logo avatar square-xs" style="background-image: url('<?php echo $pic; ?>')"></div>
                            <div class="name mgt25">{{$member->name}}</div>
                            <div class="teamtitle para-small">{{$member->position}}</div>
                            <div class="spacer"></div>
                            <a class="icon-wrapper flex-center mg15" href="{{ $member->linkdin_link }}" target="_blank"><div class="databroker-icon linkedin"></div></a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="sub-footer container-fluid app-wapper" id="about-page-mobile">
    <div class="container">
        <div class="flex-vertical flex-vcenter">
            <div class="divider-green"></div>
            <div class="h2 mgt30">Don't miss any updates!</div>
            <div class="">Sign up to our newsletter</div>
            <a href="{{route('register_nl')}}"><button class="button customize-btn mgt60">SIGN UP</button></a>
        </div>
    </div>
</div>   

@endsection

