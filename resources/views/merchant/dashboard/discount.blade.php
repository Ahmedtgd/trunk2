<?php
use App\Classes;
use App\Http\Controllers\IdController;
?>
<label class="label label-warning" id="msg_discount_loading">Loading Discounts...</label>
<h2>Discount List</h2>
<div class="row" onload="">
 <div class="col-md-12">

   <div class="table-responsive">
     <table class="table table-bordered" id="discount_details_table" style="width: 140% !important;">
       <thead>
           <?php $i=1;?>
           <tr class="bg-black" style="background: #4F6328 !important; ">
             <th class="no-sort text-center" style="background-color: #4F6328; color: white; width: 30px !important;">No</th>
             <th class="text-center large"  style="background-color: #4F6328; color: white;">Discount ID</th>
             <th class="text-center large" style="background-color: #4F6328; color: white;">Product ID</th>
             <th class="text-center bsmall" style="background-color: #4F6328; color: white;">%</th>
             <th class="text-center bsmall" style="background-color: #4F6328; color: white;">Issued</th>
             <th class="text-center bsmall" style="background-color: #4F6328; color: white;">Left</th>
			 <th class="text-center bsmall" style="background-color: #4F6328; color: white;">Status</th>
             <th class="xlarge" style="background-color: #595959; color: white;">Inscription</th>
           </tr>
         </thead>
         <tbody id="discount_table" >
         </tbody>
       </table>
     </div>
 </div>
</div>
</form>
<div id="discountLeftModal" class="modal fade" role="dialog">
          <div class="modal-dialog" style="    width: 55%;">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="left_discount_id"></h4>
              </div>
              <div class="modal-body">
                
                <div class="table-responsive">
					<table class="table table-bordered" id="left_discount_buyer_details_table">
						<thead>
							<tr class="bg-black" style="    background: #4F6328 !important; ">
								<th class="text-center">No</th>
								<th class="text-center">Discount ID</th>
								<th class="text-center">User ID</th>
								<th class="text-center">Date Issued</th>
								{{-- <th>SKU</th> --}}

								{{-- <th>Delivery Order</th> --}}
							</tr>
						</thead>
						<tbody id="left_discount_buyer_table" >

						</tbody>
					</table>
				</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
		
		<div id="discountDetail" class="modal fade" role="dialog">
          <div class="modal-dialog" >

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" id="discount_id_single"></h4>
              </div>
              <div class="modal-body">
				<div class="row">
					<div class="col-md-12 col-xs-12" style="padding-bottom: 10px;">
						<div id="discount_image_single" class="col-md-8"
						style="background-color: #f00; height: 135px; background-size: 100%; background-repeat: no-repeat;" >
						</div>
						
						<div class="col-md-4"
							style="background-color: #808080; height: 135px;    color: white; font-size:  20px">
							<span>Discount</span>
							<p id="discount_percent_single" style="margin: 15px 0px 0px 38px; font-size: 34px"></p>
						</div>
					</div>
				</div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
