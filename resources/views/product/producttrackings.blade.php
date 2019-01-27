<?php 
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\IdController;
$total=0;
$c=1;
?>
@extends("common.default")
@section("content")
@if(Auth::user()->hasRole('adm') || Auth::user()->hasRole('mer'))
@include('common.sellermenu')
@endif
<style>
    .product-photo {
        background: #f0f0f0 none repeat scroll 0 0;
        width:78px;
        min-height: 44px !important;
        text-align: center;
        color: #fff;
    }
     .product-photo .fileUpload {
        /*border: 0 none;*/
        bottom:-34px;
        right:0px !important;
        position: absolute;
    }
    .fileUpload input.upload {
        /*position: absolute;*/
        /*top: 0;*/
        /*right: 0;*/
        /*margin: 0;*/
        /*padding: 0;*/
        /*font-size: 20px;*/
        cursor: pointer;
        opacity: 0;
        /*filter: alpha(opacity=0);*/
    }
    #uploadFile{opacity: 0;}
    .product-photo .inputBtnSection {
        display: inline-block;
        font-size: 0;
        padding-top: 25%;
        vertical-align: top;
    }
    .thumbnail
    {
    	padding-top: 0px;
        height:30px;
        width:28px;
        padding-left:0px;
    }    
    .disableInputField {
        width:65px;
        display: inline-block;
        vertical-align: top;
        height: 27px;
        margin: 0;
        font-size: 14px;
        padding: 0 3px;
        color: #555 !important;
    }   
    .product-photo img[id^="bundlepreview-img"] {
        height: 300px;
    }
    img[id^="bundlepreview-img"] {
        position: absolute;
        left: 0;
        height: 170px;
    }
    .product-photo .disableInputField {
        background: #f0f0f0 none repeat scroll 0 0;
        border: 0 none;
        display: block;
    }
    .fileUpload {
    }

    .product-photo .uploadBtn {
        background: #000 none repeat scroll 0 0;
    }
    .uploadBtn {
        display: inline-block;
        /*background: #1abc9c;*/
        background: black;
        font-size: 10px;
        padding: 0 10px;
        height: 22px;
        line-height: 22px;
        color: #fff;
    }
</style>
<div class="container" style="margin-top:30px;">
	<h2>Product Ledger</h2>
	<div class="row">
		<div class="col-xs-1 col-sm-1" style="margin-bottom:10px">
			<img src="{{asset('images/product/'.$product->id.'/'.$product->photo_1)}}" style="height:50px;width:50px;vertical-align: middle;">

		</div>
		<div class="col-sm-9">
			<h3>{{$product->name}} <small><a href="{{url("productconsumer",$product->id)}}" target="_blank">{{$product->nproduct_id}}</a></small></h3>
		</div>
		<div class="col-sm-2 ">
			<a href="javascript:void(0)"
				style="padding-top:15px;padding-left:8px"
				class="btn btn-standard bg-confirm pull-right locations
				bg-location">Product<br>Location</a>
		</div>
	</div>

	<table id="producttrack" cellspacing="0" class="table table-bordered" style="width: 100%">
	    <thead>     
			<tr style="" class="bg-inventory">
				<th class='text-center'>No</th>
				<th class='text-center'>Report ID</th>
				<th class='text-center'>Type</th>
				<th class='text-center'>Last Update</th>		
				<th class="text-center" >Location</th>
				<th class="text-center" >Qty.</th>
				<th class="text-center" >Remarks</th>
				<th class="text-center" >
					<i class="fa fa-camera" style="font-size: 20px;">
					</i></th>
				{{-- <th class="text-center" >Running Total</th> --}}

			</tr>
	    </thead>

	    <tbody>
	        @if(!is_null($data))
	        <?php //echo '<pre>'; print_r($data); die();?>
	        @foreach($data as $tracking)
	        <?php
	        	$quantity=$tracking->received;
	        	$rt=$tracking->opening_balance;
	        	$url=url("stockreport",[$tracking->no,$selluser->id]);
	        	$background="white";
	        	switch ($tracking->ttype) {
	        		case 'tout':
	        			$quantity=(-1*$quantity);
	        			$rt=$rt+$quantity;
	        			break;
	        		case 'tin':
	        			$rt+=$quantity;
	        			break;
	        		case 'stocktake':
	        			$quantity=$tracking->received-$rt;
	        			
	        			break;
	        		case 'treport':
	        			# code...
	        			if ($tracking->creator_company_id==$tracking->checker_company_id) {
	        				$quantity=-1*$tracking->quantity;
	        			}elseif ($tracking->creator_company_id==$company_id) {
	        				$quantity=-1*$tracking->quantity;

	        			}else{
	        				$background="yellow";
	        			}
	        			break;
	        		case 'smemo':
	        			$quantity=$tracking->quantity;
	        			$quantity=(-1*$quantity);
	        			$url=url("salesmemo",$tracking->no);
	        			break;
	        		case 'wastage':
	        			//$quantity=$tracking->received-$rt;
	        			$quantity=(-1*$quantity);
	        			$rt=$rt+$quantity;
	        			break;
	        		case 'sales':
	        			$quantity=(-1*$tracking->quantity);
	        			$url=url("showreceiptproduct",[$tracking->no,$selluser->id]);
	        			# code...
	        			break;
	        		default:
	        	}
	        ?>
			<tr>
				<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

				<td style="text-align: center; vertical-align: middle;">
				@if($tracking->ttype=="sales")
				<a target="_blank" onclick="showopossumreceipt('{{$url}}')">{{UtilityController::nsid($tracking->no,10,"0")}}</a>
				@else
				   <a target="_blank" href="{{$url}}">{{UtilityController::nsid($tracking->no,10,"0")}}</a>
				@endif
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					@if($tracking->ttype == 'treport')
						Tracking Report
					@elseif($tracking->ttype == 'tin')
						Stock In
					@elseif($tracking->ttype == 'tout')
						Stock Out
					@elseif($tracking->ttype == 'tou')
						Stock Out
					@elseif($tracking->ttype == 'smemo')
						Sales Memo
					@elseif($tracking->ttype == 'stocktake')
						Stock Take
					@elseif($tracking->ttype == 'wastage')
						Wastage
					@elseif($tracking->ttype == 'sales')
						Sales
					@endif
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
				   {{$tracking->date_created}}
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					{{$tracking->location}}
				</td>
				<td  style="text-align: center; vertical-align: middle;">{{$quantity}}</td>
				<td style="width:300px;text-align:center;vertical-align: middle;">

				<input type="text" name="remark"
					id="originalRemark_{{$tracking->no}}" class="remark" 
					style="border:0;padding:0;width:290px;"
					onclick="add_remark1({{$tracking->no}})"
					value="@if(isset($tracking->remark) &&
					!empty($tracking->remark)) {{substr($tracking->remark,0,50) }} @endif " readonly>
				</td>

				<td style="padding:0;text-align: center; vertical-align: middle;">
					 @if(isset($tracking->image) && !empty($tracking->image))
                        <?php
                            $color= 'green';
                        ?>
                        @else
                        <?php
                            $color='grey';
                        ?>
                        @endif
					<span onclick="show_image2('{{$tracking->no}}')"><i class="fa fa-camera noupload camera_{{$tracking->no}}" style="font-size: 25px; color: {{$color}}" aria-hidden="true"id="icon_{{$tracking->no}}"></i></span>

					 <input type="hidden" name="imagePopup" id="lastimage_{{$tracking->no}}" value="{{$tracking->image}}">
					<!-- {!! Form::open(array('files' => true , 'enctype' => 'multipart/form-data', 'id' => 'saveimage_'.$tracking->no,'name' =>'saveimage','class' => 'savesisoimage')) !!}
						<input type="hidden" name="srid" value="{{$tracking->no}}"> -->
						<!-- <div class="product-photo" style="position:relative;top:3px"> -->
<!-- 							<div class="inputBtnSection">
                                <label class="fileUpload" style="margin-left:0;position:relative;top:3px;border: none;">
								{!! Form::file('image',['class'=>'upload upimage','id'=>'image_'.$tracking->no, 'required']) !!}
								<span class=""><i class="fa fa-camera camera_{{$tracking->no}}" style="font-size: 25px;color: grey;"></i></span>
								</label>
							</div> -->
						<!-- </div> -->
					<!-- {!! Form::close() !!} -->
					<!-- <i class="fas fa-camera" style="font-size: 25px;"></i> -->
					<!-- {!! Form::open(array('files' => true , 'enctype' => 'multipart/form-data', 'id' => 'saveimage_'.$tracking->no,'name' =>'saveimage','class' => 'savesisoimage')) !!} -->
					<!-- <input type="hidden" name="srid" value="{{$tracking->no}}">  -->
					<!-- <input type="file" name="image" id="image_{{$tracking->no}}" class="upimage">  -->
					<!-- {!! Form::file('image',['class'=>'upimage','id'=>'image_'.$tracking->no, 'required']) !!} -->
					<!-- <div class="" style="margin-top:0">
                        <div style="float: left;width: 100%;margin-bottom: 10px;position: relative;">
                            <input type="hidden" value="0" id="myproduct_id" name="myproduct_id" />
                            <input type="hidden" value="" name='pimage' id="ximage" />
                            <div class="thumbnail" id='thumbnail' >
                                <div class="product-photo" style="position:relative;top:3px">
                                    @if(isset($tracking->image) > 0 && $tracking->image != '')
                                    <img class="" id="bundlepreview-img_{{$tracking->no}}" style="border:0;border-color:#f0f0f0;object-fit:contain;width:75px;height: 46px;vertical-align: middle;" src="{{url()}}/images/siso/{{$tracking->no}}/{{$tracking->image}}">
                                    @else
                                    <img class="" id="bundlepreview-img_{{$tracking->no}}" style="border:0 !important;border-color:#f0f0f0 !important;object-fit:contain;width:75px;height:46px;vertical-align: middle;">
                                    @endif
                                    <div class="inputBtnSection">
                                        <label class="fileUpload"
										style="margin-left:0;position:relative;top:-1px;left:16px">
                                            {!! Form::file('image',['class'=>'upload upimage','id'=>'image_'.$tracking->no, 'required']) !!}
                                            <span class="uploadBtn badge"><i class="fas fa-upload"></i></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
					<!-- {!! Form::close() !!} -->
				</td>
				{{-- <td  style="text-align: center; vertical-align: middle;" >
				<a href="javascript:void(0)" class="locations" rel="{{$product->id}}">{{$rt}}</a>
				</td> --}}
			
			</tr>
			@if($tracking->ttype=="treport" && $tracking->status=="confirmed" && $tracking->creator_company_id==$tracking->checker_company_id)
			<?php 
				
			$c++;?>
				<tr>	
				<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

				<td style="text-align: center; vertical-align: middle;">
				  <a target="_blank" href="{{$url}}">{{UtilityController::nsid($tracking->no,10,"0")}}</a>
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					Tracking Report
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
				   {{$tracking->date_created}}
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					{{$tracking->location2}}
				</td>

				<td  style="text-align: center; vertical-align: middle;">
					{{($tracking->received)}}
				</td>
			</tr>
			@endif
			
		
			@if($tracking->ttype=="smemo" && $tracking->status=="voided")
				<?php $c++;?>
				<tr>	
				<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

				<td style="text-align: center; vertical-align: middle;">
				   <a target="_blank" href="{{url("salesmemo",$tracking->no)}}">{{UtilityController::nsid($tracking->sequence,10,"0")}}</a>
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					Sales Memo (Voided)
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
				   {{$tracking->date_created}}
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					{{$tracking->location}}
				</td>

				<td  style="text-align: center; vertical-align: middle;">
					{{(-1*$quantity)}}
				</td>

				{{-- <td  style="text-align: center; vertical-align: middle;" >
				<a href="javascript:void(0)" class="locations" rel="{{$product->id}}">{{$rt}}</a>
				</td> --}}
			
			</tr>
			@elseif($tracking->ttype=="sales" && $tracking->status=="voided")
				<?php $c++;?>
				<tr>	
				<td style="text-align: center; vertical-align: middle;">{{$c}}</td>

				<td style="text-align: center; vertical-align: middle;">
				   <a target="_blank" onclick="showopossumreceipt('{{$url}}')">{{UtilityController::nsid($tracking->sequence,10,"0")}}</a>
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					Sales(Voided)
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
				   {{$tracking->date_created}}
				</td>
				
				<td style="text-align: center; vertical-align: middle;">
					{{$tracking->location}}
				</td>
				<td  style="text-align: center; vertical-align: middle;">
				{{(-1*$quantity)}}
				</td>
				{{-- <td  style="text-align: center; vertical-align: middle;" >
				<a href="javascript:void(0)" class="locations" rel="{{$product->id}}">{{$rt}}</a>
				</td> --}}
			
			</tr>
			@endif
			<?php $c++;?>
			<!-- <div class="modal fade" id="editRemark_{{$tracking->no}}" role="dialog" aria-labelledby="myModalLabel">
			    <div class="modal-dialog" role="document" style="width: 50%">
			        <div class="modal-content"
						style="padding-left:10px;padding-right:10px">
			            <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal"
							aria-label="Close">
							<span aria-hidden="true">&times;</span></button>
			                <h2 class="modal-title" id="myModalr">Remarks</h2>
			            </div>
			            <div class="modal-body" style="padding:15px;">
			            	<textarea rows="5" name="remarks"
							id="remark_{{$tracking->no}}"
							onblur="saveremark({{$tracking->no}});"
							style="width:100%">@if(isset($tracking->remark)){{ $tracking->remark }}@endif</textarea>
							<button type="button" class="btn bg-save" style=" padding-bottom: 5px; float: right;" id="savePRemark">Save</button>
			            </div> -->
						<!--
			            <div class="modal-footer">
			                <button type="button" class="btn btn-default"
							data-dismiss="modal">Close</button>
			            </div>
						-->
			<!-- 			<br>
			            
			        </div>
			    </div>
			</div> -->


			<div class="modal fade" id="editRemark_{{$tracking->no}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="height: 200px;">
			  <div class="modal-dialog" style="width: 400px;">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
			            <!-- <span class="sr-only">Close</span> -->
			        </button>
			        <h4 class="modal-title" id="myModalLabel">Remarks</h4>
			      </div>
			      <div class="modal-body" style="margin-right: 15px;padding-bottom: 3px;
    padding-right: 0px;padding-left: 0px;">
			       <textarea rows="5" name="remarks"
							id="remark_{{$tracking->no}}"
							style="width:100%;height: 43px;">@if(isset($tracking->remark)){{ $tracking->remark }}@endif</textarea>
			        
			        <input type="hidden" id="remarkproductid">
			       
			      </div>
			      <div class="modal-footer" style="padding-top: 0px;border-top: none">
			        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
			        <button type="button" class="btn bg-save" id="" onclick="saveremark({{$tracking->no}});" style="border-radius:5px;">Save</button>
			      </div>
			    </div>
			  </div>
			</div>



	        @endforeach
	        @endif
	    </tbody>
	</table>
</div>
<br><br>
<div class="modal fade" id="myModalLocation" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 50%">
        <div class="modal-content"
			style="padding-left:10px;padding-right:10px">
            <div class="modal-header" style="margin-bottom:20px">
                <button type="button" class="close" data-dismiss="modal"
				style="color:black" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title" id="myModalLabel">Product Location</h3>
            </div>
            <div class="modal-body-locations">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- Receipt model end -->
<div class="modal fade oreceipt" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:400px;height: 100%;">
    <div class="modal-content">
       
        <iframe src="" frameborder="0" style="width: 400px;height:1200px !important;" scrolling="no" id="myframe"></iframe>
      </div>
  </div>
</div>

<div class="modal fade" id="editImage" role="dialog">
    {!! Form::open(array('files' => true , 'enctype' => 'multipart/form-data', 'id' => 'frmeditProfile_side')) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-body login-pad">
                        <div class="pop-title employe-title">
                          <h3>EDIT PROFILE PICTURE</h3>
                        </div>
                        <div class="signup">
                          
                        </div>
                    </div>
                  </div>
                  
                </div>
                {!! Form::close() !!}
              </div>

<div class="modal fade" id="attachImageModalpreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  style="height: 400px;">
  <div class="modal-dialog" style="width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image Preview</h4>
      </div>
      <div class="modal-body" id="modelBody" style="min-height: 100% !important;">
        <img src="" id="imagepreview" style="width:100%; height: 215px; " >

       <!--  <label class="fileUpload" id="imagemodelview2" style="margin-left:0;position:relative;top:11px;border:none; float: right;padding-right: 20px;;">
           <input type="file" name="image" id="imagefile" class="upload">
           <span class="uploadBtn badge" style="background: black;padding: 3px 7px !important;    height: 30px !important;"><i class="fas fa-upload" style="
    font-size: 21px;"></i></span>
       	</label> -->

       	<label class="fileUpload" id="imagemodelview2" style="margin-left:0;position:relative;top:-50px;right: 25px;
   float: right;border:none">
           <input type="file" name="image" id="imagefile" class="upload">
           <span class="uploadBtn badge" style="background: black;"><i class="fa fa-upload"></i></span>
       </label>

        <!-- <input type="file" name="image" id="imagefile"> -->
        <input type="hidden" id="imagepreviewproductid">
        <span id="uploadmessagesuccess" class="text-success"></span>
      </div>
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
        <button type="button" class="btn bg-save" data-dismiss="modal" style="border-radius: 5px;">Save</button>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
	product_id={{$product->id}}
	function showopossumreceipt($url) {
            $('.oreceipt').on('shown.bs.modal',function(){      //correct here use 'shown.bs.modal' event which comes in bootstrap3
                $(this).find('iframe').attr('src',$url)
            });
            $(".oreceipt").modal("show")
       }

  	$(document).ready(function(){
		$(document).delegate( '.locations', "click",function (event) {
			var id = $(this).attr('rel');
			$.ajax({
				url: "{{url("productlocations",[$product->id,$selluser->id])}}",
				cache: false,
				method: 'GET',
				success: function(result, textStatus, errorThrown) {
					$(".modal-body-locations").html(result);
					$("#myModalLocation").modal('show');
				}
			});	
		});		  	  
		var table = $('#producttrack').DataTable({
			"order": [],
			"columnDefs": [
				{"targets": 'no-sort', "orderable": false, },
				{"targets": "medium", "width": "80px" },
				{"targets": "large",  "width": "120px" },
				{"targets": "approv", "width": "180px"},
				{"targets": "blarge", "width": "200px"},
				{"targets": "bsmall",  "width": "20px"},
				{"targets": "clarge", "width": "250px"},
				{"targets": "xlarge", "width": "300px" }
			]
		});
		$(".dataTables_empty").attr("colspan","100%");

	 	

  	});

	function saveremark(no)
	{
		console.log(no);
		var remark = $('#remark_'+no).val();

		console.log(remark);
		if(remark != '')
		{
			var SubRemark = remark.substring(0,50);
            $('#originalRemark_'+no).val(SubRemark+'...');

			$.ajax({
				url: "{{URL('/producttracking/saveremarks')}}",
				method: 'POST',
				data: {remark:remark,srId:no,product_id},
				success: function(r) {
					// if(r.status == "success")
					// {
						$("#editRemark_"+no).modal("hide");
						toastr.success("Remark save Successfully");
						console.log("save success");

					// }					
				}
			});	
		}else{
			toastr.error("Please add remark");
		}	
 	}
 	var _URL = window.URL || window.webkitURL; 
// $("#imagefile").change(function() {
//         
//         // filename = upload_image($this, product_id)
//         // update_stockreport(product_id, 'image', filename)
// })

  	$("#imagefile").change(function () {
  		console.log('imagefile');
		
		$this = $(this);
        readURL(this)
        var no = $("#imagepreviewproductid").val()
 	
        
        console.log(no);
       	var filename= upload_image($this, no);       
       	$("#lastimage_"+no).val(filename.image);
  		//var id = $(this).attr('id');

	    // var iid = id.split("_");
	    // var no = iid[1];
	    // var no= $(this).val();
	    // console.log(no);
	    // var uploadbtn = this;
     //   	var file = this.files[0];
     //   	var img = new Image();
     //   	var sizeKB = file.size / 1024;
       	// img.onload = function() {
        //     var img_width = img.width;
        //     var img_height = img.height;
        //     //if(parseFloat(img_width) == 345 && parseFloat(img_height) == 300){
        //         // x = $("#image_"+no).val();
        //     //  console.log(x);
        //         // $('#ximage').val(x);
        //         // readURLSingle(uploadbtn, 'bundlepreview-img_'+no);
        //         // $('#thumbnail').removeClass('errorDoubleBorder');               
        //     /*} else {
        //         toastr.error("Incorrect image dimensions, please, select a valid image");
        //     }*/
       	// }
       	// img.src = _URL.createObjectURL(file);     
	    //var receiptImage = new FormData($("#saveimage_"+no)[0]);      
	    // var receiptimage = $('#imagefile'+no).val();
	 //    console.log(receiptImage);
		// console.log(receiptimage); 
	 //    if(receiptImage != '')
  //       {
	 //  		$.ajax({
		// 		url: "{{URL('/producttracking/saveimage')}}",
		// 		type: 'POST',
		// 		dataType: 'json',
  //               data:receiptImage,
  //               processData:false,
  //               contentType:false,
		// 		success: function(r) {
		// 			$('.camera_'+no).css('color', 'green');
		// 			toastr.success("Image Uploaded Successfully");
		// 			// console.log("save success");
		// 		}
		// 	});
		// }	   
  	});

  	function add_remark1(id)
  	{
  		$("#editRemark_"+id).modal("show");
  	}
    // $("#sisofile").change(function () {
    //    var uploadbtn = this;
    //    var file = this.files[0];
    //    var img = new Image();
    //    var sizeKB = file.size / 1024;
    //    img.onload = function() {
    //         var img_width = img.width;
    //         var img_height = img.height;
    //         //if(parseFloat(img_width) == 345 && parseFloat(img_height) == 300){
    //             x = $("#sisofile").val();
    //         //  console.log(x);
    //             $('#ximage').val(x);
    //             readURLSingle(uploadbtn, 'bundlepreview-img');
    //             $('#thumbnail').removeClass('errorDoubleBorder');               
    //         /*} else {
    //             toastr.error("Incorrect image dimensions, please, select a valid image");
    //         }*/
    //    }
    //    img.src = _URL.createObjectURL(file);        
    // }); 

    // function readURLSingle(input, id) {
    //     var fileTypes = ['jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls'];  //acceptable file types

    //     if (input.files && input.files[0]) {
    //         var extension = input.files[0].name.split('.').pop().toLowerCase(), //file extension from input file
    //             isSuccess = fileTypes.indexOf(extension) > -1;  //is extension in acceptable types
    //         if (isSuccess) { //yes
    //             var reader = new FileReader();
    //             reader.onload = function (e) {
    //                 $('#' + id).attr('src', e.target.result);
    //                 $('.product-photo').css('background', 'none');
    //                 $('.product-photo .fileUpload').css('bottom', '10px !important');
    //             }
    //             reader.readAsDataURL(input.files[0]);
    //         }
    //         else { //no
    //             toastr.error("Warning: Type mismatch");
    //         }
    //     }
    // }
    function show_image2(no) {
    $('#imagepreviewproductid').val(no);
    var image = $('#lastimage_'+no).val();
    if(image != ''){
    	$('#imagepreview').show();
    	$('#imagemodelview2').css('top',"-40px");
	 	$("#imagepreview").attr('src', "{{url()}}/images/siso/"+product_id+"/"+image.trim());
	  	
    }else{
    	$('#imagemodelview2').css('top',"-10px");
    	$('#imagepreview').hide();
    }
    $('#attachImageModalpreview').modal('show');
    console.log(image);
   
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#imagepreview').attr('src', e.target.result);

        }

        reader.readAsDataURL(input.files[0]);
    }
}
function upload_image($this, no) {
    // body...

    image = $this[0].files[0];
    data = new FormData();
    data.append("image", image)
    data.append("type", "siso")
    data.append("srid", no)
    data.append("product_id",product_id)
    url = "{{URL('/producttracking/saveimage')}}"
    type = "POST"

    success = function(r) {
        console.log(r.image)
        filename = r
        $('.camera_'+no).css('color', 'green');
		toastr.success("Image Uploaded Successfully");
		$('#imagemodelview2').css('top',"-40px");
		$("#imagepreview").attr('src', "{{url()}}/images/siso/"+product_id+"/"+r.image);
		$('#imagepreview').show();
        $("#uploadmessagesuccess").text("File has been uploaded");
        $("#icon_" + no).addClass('upload')
    }
    /*Sync Onlu*/
    filename = "";
    $.ajax({
        url,
        async: false,
        cache: false,
        contentType: false,
        processType: false,
        processData: false,
        type,
        success,
        data
    })
    return filename
}


</script>
@stop
