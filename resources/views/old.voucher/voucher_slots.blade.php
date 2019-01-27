{{--
 @author: goodluck mlwilo
 @email:nivalamata@gmail.com
 @on: 7/3/16
 @time:6:04 PM
--}}

<div class="col-md-12" style="padding-right:0">
    <button  class="btn btn-info pull-right"
            style="margin-top:-9px;margin-bottom:5px;margin-right:0"
            type="button" id="modal-slot-add">Add Slot
    </button>
</div>

<table id="modal-voucher-slot" class=" table table-bordered">
    <thead>
    <tr class="bg-black" >
        <th class="text-center no-sort">No</th>
        <th class="text-center no-sort">From</th>
        <th class="text-center no-sort">To</th>
        <th class="text-center no-sort">Price</th>
        <th class="text-center no-sort">Qty Left</th>
        <th class="text-center no-sort">Action</th>
    </tr>
    </thead>
    <tbody>

    <?php $i = 1; ?>
    @foreach($slots as $slot)
        <tr id="slot{{$slot->id}}" >
            <td class="text-center"><?php echo $i++; ?></td>
            <td>
                {{$slot->from or ''}}
            </td>
            <td>
                {{$slot->to or ''}}
            </td>

            <td>
                {{$slot->price or ''}}
            </td>
            <td>
                {{$slot->qty_left or ''}}
            </td>
            <td></td>

        </tr>

    @endforeach
    </tbody>
</table>
