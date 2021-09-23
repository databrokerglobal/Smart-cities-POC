@extends('layouts.admin')

@section('additional_css')
    <!-- <link rel="stylesheet" href="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.css') }}"> -->
@endsection

@section('content')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
   
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator"><b style="color: #06038D;">Dashboard</b></h3>                
            </div>
            <h3> <b style="color: #9102f7;"> <a href="{{ route('admin.howtouse') }}"> How to use</a></b>&nbsp;&nbsp;&nbsp;</h3>
        </div>
       
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        <div class="m-portlet m-portlet--mobile">
            <!-- <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">
                            <li class="m-portlet__nav-item">
                            <h3><span>Quick Summary</span>  </h3>                                 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>--> 
            <div class="m-portlet__body">


<div class="form-group m-form__group row">     
            <!--TILE Start-->
            <div class="col-lg-5 col-sm-5 mb-12"> 
                    <canvas id="clients"  width="850" height="600"></canvas> 
                   
            </div>   
            <div class="col-lg-7 col-sm-7 mb-12 align-self" > 
                <div id="graph-container">
                    <canvas id="canvas" width="850" height="400"></canvas>
                    <div class="footer-legend"><b>Number of Companies</b></div>
                </div>
                <span class="btn btn-primary text-left" style="margin-top: 10px;" id="changeGraph" data-type="percent">Change to Percentage(%)</span>
            </div>   
           
            <!--TILE end-->  
</div>
<hr/>
<div class="form-group m-form__group row">     
            <!--TILE Start-->
            <div class="col-lg-4 col-sm-6 mb-4"> 
            <a class="no-underline" href="{{ route('admin.users') }}">  
                <div class="tile1 card-dasboard">
                    <div class="card-body">
                            <div class="card-count d-inline float-left">{{$totalUsers}}
                            <span>Users</span>
                            </div>
                            <i class="fas fa-users f-24 align-middle d-icon float-right"></i>
                            <div class="clearfix"></div>
                    </div>
                    <hr class="hr4 m-0">
                        <div class="card-body py-2 px-3"><p class="card-text f-14"><span title="All users with email verified">Active: {{$activeUsers}} </span> | <span title="Inactive Users"> Verifying: {{$inactiveUsers}} </span> | <span title="All users with email verified"> Buyers: {{$activeUsers}} </span> |  <span title="Active users with ≥1 data offer (published or not)"> Sellers: {{$sellerCount}} </span></p></div>
                </div> 
                </a>   
            </div>   
            <!--TILE end-->   
               <!--TILE Start-->
               <div class="col-lg-4 col-sm-6 mb-4"> 
               <a class="no-underline" href="{{ route('admin.offers') }}">     
                <div class="tile2 card-dasboard">
                    <div class="card-body">
                            <div class="card-count d-inline float-left">{{$totalOffers}}
                                <span>Offers</span>
                            </div>
                            <i class="fa fa-gift f-24 align-middle d-icon float-right"></i>
                            <div class="clearfix"></div>
                    </div>
                    <hr class="hr4 m-0">
                        <div class="card-body py-2 px-3"><p class="card-text f-14"><span title="Number of data offers published"> Active: {{$activeOffres}} </span> | <span title="Inactive Offers"> Inactive: {{$inactiveOffers}} </span></p></div>
                </div>  
                </a>  
            </div>   
            <!--TILE end-->  
               <!--TILE Start-->
               <div class="col-lg-4 col-sm-6 mb-4">
               <a class="no-underline" href="{{ route('admin.providers') }}">   
                <div class="tile3 card-dasboard">
                    <div class="card-body">
                            <div class="card-count d-inline float-left">{{$totalProviders}}
                                <span>Providers</span>
                            </div>
                            <i class="fa fa-industry f-24 align-middle d-icon float-right"></i>
                            <div class="clearfix"></div>
                    </div>
                    <hr class="hr4 m-0">
                        <div class="card-body py-2 px-3"><p class="card-text f-14">&nbsp;</p></div>
                </div>
                </a>    
            </div>   
            <!--TILE end-->  
</div>

<div class="form-group m-form__group row">
            
               <div class="col-lg-4 col-sm-6 mb-4">   
                    <a class="no-underline" href="{{ route('admin.purchases') }}">  
                    <div class="tile4 card-dasboard">
                        <div class="card-body">
                                <div class="card-count d-inline float-left">{{$totalPurchase}}
                                    <span>Purchases</span>
                                </div>
                                <i class="fa fa-shopping-cart f-24 align-middle d-icon float-right"></i>
                                <div class="clearfix"></div>
                        </div>
                        <hr class="hr4 m-0">
                            <div class="card-body py-2 px-3"><p class="card-text f-14">&nbsp;</p></div>
                    </div> 
                    </a>   
                </div>   
               <div class="col-lg-4 col-sm-6 mb-4">   
                    <a class="no-underline" href="{{ route('admin.products') }}">  
                    <div class="tile7 card-dasboard">
                        <div class="card-body">
                                <div class="card-count d-inline float-left">{{$OfferProducts}}
                                    <span>Products</span>
                                </div>
                                <i class="fa fa-info f-24 align-middle d-icon float-right"></i>
                                <div class="clearfix"></div>
                        </div>
                        <hr class="hr4 m-0">
                        <div class="card-body py-2 px-3"><p class="card-text f-14"><span title="Number of data products published with DXC running"> Active: {{$ActiveOfferProducts}} </span></p></div>
                    </div> 
                    </a>   
                </div>   
            
            <!--TILE end-->  
             <!--TILE Start-->
             <div class="col-lg-4 col-sm-6 mb-4"> 
             <a class="no-underline" href="{{ route('admin.usecases', [ 'id' => 1 ]) }}">
                <div class="tile5 card-dasboard">
                    <div class="card-body">
                            <div class="card-count d-inline float-left">{{$totalArticles}}
                                <span>Articles</span>
                            </div>
                            <i class="fa fa-newspaper-o f-24 align-middle d-icon float-right"></i>
                            <div class="clearfix"></div>
                    </div>
                    <hr class="hr4 m-0">
                        <div class="card-body py-2 px-3"><p class="card-text f-14"><span title="Active Articles">Active: {{$activeArticles}} </span> | <span title="Inactive Articles"> Inactive: {{$inactiveArticles}} </span></p></div>
                </div> 
                </a>   
            </div>   
            <!--TILE end-->  
              <!--TILE Start-->
              <div class="col-lg-4 col-sm-6 mb-4"> 
             <a class="no-underline" href="{{ route('admin.updates') }}">
                <div class="tile5 card-dasboard">
                    <div class="card-body">
                            <div class="card-count d-inline float-left">{{$totalUpdates}}
                                <span>Updates</span>
                            </div>
                            <i class="fa fa-newspaper-o f-24 align-middle d-icon float-right"></i>
                            <div class="clearfix"></div>
                    </div>
                    <hr class="hr4 m-0">
                        <div class="card-body py-2 px-3"><p class="card-text f-14"><span title="Active Updates">Active: {{$activeUpdates}} </span> | <span title="Inactive Articles"> Inactive: {{$inactiveUpdates}} </span></p></div>
                </div> 
                </a>   
            </div>   
            <!--TILE end--> 
             <!--TILE Start-->
             <div class="col-lg-4 col-sm-6 mb-4">   
                <div class="tile6 card-dasboard">
                    <div class="card-body">
                            <div class="card-count d-inline float-left">{{$totalBids}}
                                <span>Bids</span>
                            </div>
                            <i class="fa fa-gavel f-24 align-middle d-icon float-right"></i>
                            <div class="clearfix"></div>
                    </div>
                    <hr class="hr4 m-0">
                        <div class="card-body py-2 px-3"><p class="card-text f-14">&nbsp;</p></div>
                </div>    
            </div>   
            <!--TILE end-->  

</div>













            </div>
        </div>
    </div>
</div>
@endsection

@section('additional_javascript')
<script src="{{asset('adminpanel/js/chart.js')}}" type="text/javascript"></script>
    <!-- <script src="{{ asset('adminpanel/assets/vendors/custom/datatables/datatables.bundle.js') }}"></script>         -->
    <script>
      //  $(function(){

      
		var barChartData = {
			labels: ['<?php echo $dates ?>'],
			datasets: [{
				label: 'Users ',
				backgroundColor: "#299781",
                borderColor: "#299781",
                
				borderWidth: 1,
				data: [
                    '<?php echo $userCount ?>'
				]
            }]
            

		};

		

     
    
		
		var color = Chart.helpers.color;
		var horizontalBarChartData = {
			labels: ['<?php echo implode("','",$communities) ?>'],
			datasets: [{
				label: 'Buyers',
				backgroundColor: color("#7EF5DD").alpha(1).rgbString(),
				borderColor: "#7EF5DD",
				borderWidth: 1,
				data: [
				    <?php echo implode(',',$buyers) ?>
				]
			}, {
				label: 'Sellers',
				backgroundColor: color("#06038D").alpha(1).rgbString(),
				borderColor: "#06038D",
				data: [
                    <?php echo implode(',',$sellers) ?>
				]
			}]

        };
        
		var horizontalBarChartData2 = {
			labels: ['<?php echo implode("','",$communities) ?>'],
			datasets: [{
				label: 'Buyers',
				backgroundColor: color("#001dff").alpha(1).rgbString(),
				borderColor: "#001dff",
				borderWidth: 1,
				data: [
				    <?php echo implode(',',$buyerPercent) ?>
				]
			}, {
				label: 'Sellers',
				backgroundColor: color("#78e6d0").alpha(1).rgbString(),
				borderColor: "#78e6d0",
				data: [
                    <?php echo implode(',',$sellerPercent) ?>
				]
			}]

        };
        
        $('#changeGraph').on('click',function(){
                
                $('#canvas').remove();
                $('#graph-container').html('<canvas id="canvas" width="850" height="400"></canvas>');
                var ctxc = document.getElementById('canvas').getContext('2d');
                if($(this).attr('data-type') == "percent"){
                    $(this).attr('data-type','number');
                    $(this).html('Change to Numbers');
                    $('#graph-container').append('<div class="footer-legend"><b>Percentage of Companies</b></div>');
                    window.myHorizontalBar = new Chart(ctxc, {
                        type: 'horizontalBar',
                        data: horizontalBarChartData2,
                        tooltipTemplate: "<%= value %> Files",
                        options: {
                            // Elements options apply to all of the options unless overridden in a dataset
                            // In this case, we are setting the border of each horizontal bar to be 2px wide
                            tooltips: {
                                enabled: true,
                                
                                callbacks: {
                                    label: function(tooltipItem, data) {
                                        var label = data.datasets[tooltipItem.datasetIndex].label || '';

                                        if (label) {
                                            label += ': ';
                                        }
                                        label += tooltipItem.xLabel+'%';
                                        return label;
                                    }
                                }
                            },
                            elements: {
                                rectangle: {
                                    borderWidth: 1,
                                }
                            },
                            responsive: true,
                            legend: {
                                position: 'right',
                            },
                            title: {
                                display: true,
                                text: 'Communities of data Buyers & Sellers'
                            },
                            scales: {
                                    xAxes: [{
                                        gridLines: {
                                            show: true,
                                            beginAtZero: true,
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                        //beginAtZero: true,
                                    
                                        }
                                    }]
                            }
                        }
                    });
                }else{
                    $(this).attr('data-type','percent');
                    $('#graph-container').append('<div class="footer-legend"><b>Number of Companies</b></div>');
                    $(this).html('Change to Percentage(%)');
                    window.myHorizontalBar = new Chart(ctxc, {
                        type: 'horizontalBar',
                        data: horizontalBarChartData,
                        options: {
                            // Elements options apply to all of the options unless overridden in a dataset
                            // In this case, we are setting the border of each horizontal bar to be 2px wide
                            elements: {
                                rectangle: {
                                    borderWidth: 1,
                                }
                            },
                            responsive: true,
                            legend: {
                                position: 'right',
                            },
                            title: {
                                display: true,
                                text: 'Communities of data Buyers & Sellers'
                            },
                            scales: {
                                    xAxes: [{
                                        gridLines: {
                                            show: true,
                                            beginAtZero: true,
                                        }
                                    }],
                                    yAxes: [{
                                        ticks: {
                                        //beginAtZero: true,
                                    
                                        }
                                    }]
                            }
                        }
                    });
                }
        })

		window.onload = function() {
            var ctx = document.getElementById('clients').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'bar',
				data: barChartData,
				options: {
                    responsive: true,
                    scales: {
                    yAxes: [{
                        ticks: {
                        beginAtZero: true,
                        callback: function(value) {if (value % 1 === 0) {return value;}}
                        }
                    }]
                    },
                    legend: {
                        display: false,
						position: 'top',
					},
					title: {
						display: true,
						text: 'Users registered between <?php echo date('F d',$lastBackDate) ?> To <?php echo date('F d, Y') ?>'
					}
				}
            });
            
			var ctxc = document.getElementById('canvas').getContext('2d');
			window.myHorizontalBar = new Chart(ctxc, {
				type: 'horizontalBar',
				data: horizontalBarChartData,
				options: {
					// Elements options apply to all of the options unless overridden in a dataset
					// In this case, we are setting the border of each horizontal bar to be 2px wide
					elements: {
						rectangle: {
							borderWidth: 1,
						}
					},
					responsive: true,
					legend: {
						position: 'right',
					},
					title: {
						display: true,
						text: 'Communities of data Buyers & Sellers'
                    },
                    scales: {
                            xAxes: [{
                                gridLines: {
                                    show: true,
                                    beginAtZero: true,
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                //beginAtZero: true,
                               
                                }
                            }]
                    }
				}
			});

		};

	

		var colorNames = Object.keys(window.chartColors);

		
	
          

</script>
@endsection

