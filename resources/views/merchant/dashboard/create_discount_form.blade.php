<?php 
	use App\Http\Controllers\IdController;
?>
<form enctype="multipart/form-data" id="discountForm" >
        <div class="row">
            <div class="col-md-6">
            <p id="msg_sucess_discount" style="display: none" class="alert alert-success">Success: Discount Added</p>
            <p id="msg_error" style="display: none" class="alert alert-danger">There are some errors</p>
                <label>Product</label>
                <select name="discount_product" class="form-control">
                    <option>Select Product</option>
                    @foreach($merchant_products as $product)
                        <option value="{{$product->id}}">{{IdController::nP($product->id)}}-{{$product->name}}</option>
                    @endforeach
                </select>
                <span class="text-danger" id="err_discount_product"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">

                <div class="col-md-8"
					style="background-color: #f00;height: 200px; margin-top: 10px; margin-bottom: 20px">
                <div class="row thumbnail"
					style="height: 100%; background-color: #f00 !important;border:none !important;width:110% ">
                    <div class="product-photo"
						style="min-height: 190px;  !important">
                        <div class="img-responsive"
							style="height: 100%;width: 100%;margin-top: -4px; margin-right: -1px;
							background-size: auto 100%;
							background-image:url({{asset('images/discount/default/default.jpg')}});"
							id="imagePreviewDiscount" ></div>
                        <div class="inputBtnSection">
                            {!! Form::text('photo',null,
								['class'=>'disableInputField text-center','
									id'=>'uploadFile','placeholder'=>'Add Photo','disabled'=>'disabled']) !!}
                            <label class="fileUpload">
                                <input name="discount_image"
									class='upload' id='uploadBtnDiscount'
									type="file" accept="image/*" />
                                <span class="uploadBtn badge">
									<i class="fa fa-lg fa-upload"></i> </span>
                            </label>
                        </div>
                    </div>
                </div>
                <div  style="margin-top: -23px">
                    <p class="text-danger" id="err_discount_image"></p>
                </div>
            </div>
            <div class="col-md-4"
				style="background-color: #808080; height: 200px; margin-top: 10px;margin-bottom: 13px">


                <div class="" style="margin-top: 38px">
                    <p class="text-danger" id="err_discount_percentage"></p>
                </div>
            </div>
            

            </div>
            <div style="margin-top:10px" class="col-md-2">
				<label style="margin-top:5px">Discount (%)</label>
				<div class="input-group" style="  width:150px  ">
					<a  href="javascript:void(0);"
						onClick="discount_percentage_inc()"
						class="input-group-addon"
						style="background: rgb(39,169,138);cursor: pointer;">
						<i class="fa fa-plus" style="color: #ffffff"></i></a>
					<input name="percentage"
						class="form-control text-center numeric"
						type="hidden" value="0" />
					<input name="discount_percentage"
						onblur="discount_percentage()"
						class="form-control text-center numeric"
						type="text" value="0" />

					<a href="javascript:void(0);"
						onClick="discount_percentage_dec()" 
						class="input-group-addon"
						style="background: rgb(39,169,138);cursor: pointer;" >
						<i class="fa fa-minus" style="color: #ffffff"></i></a>
				</div>
				<label style="margin-top:5px">Duration (days)</label>
				<div class="input-group" style="  width:150px">
					<a  href="javascript:void(0);"
						onClick="increase_val('','discount_duration')"
						class="input-group-addon"
						style="background: rgb(39,169,138);cursor: pointer;">
						<i class="fa fa-plus" style="color: #ffffff"></i></a>
					<input name="discount_durationff"
						class="form-control numeric text-center"
						onblur="change_val('','discount_duration')"
						value="0" type=" text" />
					<input  name="discount_duration"
						class="hidden form-control numeric text-center"
						value="0" type=" number" />

					<a href="javascript:void(0);"
						onClick="decrease_val('','discount_duration')"
						class="input-group-addon"
						style="background: rgb(39,169,138);cursor: pointer;" >
						<i class="fa fa-minus" style="color: #ffffff"></i></a>
				</div>
				<span class="text-danger" id="err_discount_duration"></span>

				<label style="margin-top:5px;">Issue (tickets)</label>
				<div class="input-group" style="width:150px">
					<a  href="javascript:void(0);"
						onClick="increase_val('','discount_quantity')"
						class="input-group-addon"
						style="background: rgb(39,169,138);cursor: pointer;">
						<i class="fa fa-plus" style="color: #ffffff"></i></a>
					<input name="discount_quantityff"
						class="form-control text-center numeric"
						onblur="change_val('','discount_quantity')"
						type="text" value="0" />
					<input name="discount_quantity"
						class="hidden form-control text-center numeric"
						type="number" value="0" />
					<a href="javascript:void(0);"
						onClick="decrease_val('','discount_quantity')"
						class="input-group-addon"
						style="background: rgb(39,169,138);cursor: pointer;" >
						<i class="fa fa-minus" style="color: #ffffff"></i></a>
				</div>
				<p class="text-danger" id="err_discount_quantity"></p>
            </div>
        </div>
        
        <div class="row">
            
            <div class="col-md-8">
                <label>Inscription</label>
                <textarea name="discount_remarks"
				id="txt_remarks" class="form-control"></textarea>
            </div>
            <div class="col-md-4">
                <br>
                <input style="margin-top: 6px"
				value="Submit" id="form_submit_button"
				type="submit" class="btn btn-success pull-left" />
            </div>
       
        </div>
</form>
