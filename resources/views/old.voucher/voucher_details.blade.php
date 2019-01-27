{{--
 @author: goodluck mlwilo
 @email:nivalamata@gmail.com
 @on: 7/3/16
 @time:6:04 PM
--}}

{!! Html::style('css/editablegrid/editablegrid.css') !!}
{!! Html::style('css/jquery-ui-timepicker-addon.min.css') !!}
<style>
    table.dataTable th, td {
        max-width: none !important;
        white-space: nowrap;

    }

</style>


<table id="tab-voucher-detail" class="table-bordered"
       style="width: 100% !important;" cellspacing="0"
       data-product-voucher-route="{{ route('voucher-update') }}">
    <thead>
    <tr class="bg-black">
        <th>No</th>
        <th>O</th>
        <th>SMM</th>
        <th>Date</th>
        <th>Voucher ID</th>
        <th class="text-center xlarge">Name</th>
        <th>Brand</th>
        <th>Category</th>
        <th>SubCategory</th>
        <th>Retail</th>
        <th>Details</th>

    </tr>
    </thead>
    <tbody>

    <?php $i = 1; ?>
    @foreach($product_vouchers as $product_voucher)
        <tr id="row_{{$product_voucher->voucher->id}}"
            data-voucher-route="{{ route('voucher-update', $product_voucher->voucher->id) }}">
            <td  data-column="no" class="text-center no">
                <?php echo $i++; ?></td>

            <td data-column="oshop_selected" class="oshop_selected">
                {{$product_voucher->oshop_selected or ''}}
            </td>

            <td data-column="smm_selected" class="smm_selected">
                {{$product_voucher->smm_selected or ''}}
            </td>
            <td data-column="created_at" class="created_at">
                {{$product_voucher->voucher->created_at or ''}}
            </td>
            <td data-column="voucher_id" class="voucher_id">
                {{$product_voucher->voucher->id or ''}}
            </td>

            <td data-column="name" class="name">
                {{$product_voucher->name or ''}}
            </td>
            <td data-column="brand" class="brand">
                {{$product_voucher->brand->name or ''}}
            </td>
            <td data-column="category" class="category">
                {{$product_voucher->category->description or ''}}
            </td>

            <td data-column="sub_cat" class="sub_cat">
                {{$product_voucher->subCat->description or ''}}
            </td>

            <td data-column="retail_price" class="retail_price">
                {{$currency->code}} {{ $product_voucher->retail_price or ''}}
            </td>
            <td  data-column="detail" class="detail">
                <a
                        href="javascript:void(0)"
                        data-toggle="modal"
                        data-target="#slotModal"

                        data-voucher_id="{{$product_voucher->voucher->id}}"
                        data-voucher_name="{{$product_voucher->name}}"
                        data-route="{{ route('voucher-timeslots', $product_voucher->voucher->id) }}"
                >
                    Details
                </a>

            </td>
        </tr>
    @endforeach
    </tbody>
</table>

<br>

{{--Model Start--}}
<div class="modal fade" tabindex="-1" role="dialog" id="slotModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{--Model End--}}
