<?php

namespace App\Listeners;

use App\Events\PorderStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Delivery;
use App\Models\OrderDeliveryPath;
use DB;

class InsertOrderDeliveryPath
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PorderStatusChanged  $event
     * @return void
     */
    public function handle(PorderStatusChanged $event)
    {
        //var_dump('Notify:' . $event->porder_id . ' is the Porder Id and '.$event->porder_status. ' is the Status');

        /*  STEPS:
          Get porder_id for the order to be save and I have it as an Event Argument...
          Get status_state_id and I have status_name as an Event Argument here...
          Get delivery_id if it exists for that porder_id
          Insert a new Record for the Same porder with increment of 1 in path_no    
      
        $porder_id = $event->porder_id;
        //  for very first entry, path_no should be 1
        $path_no = 1;

        //  get status_state_id for current porder.status from statusstate table
        $statusstate = DB::table('statusstate')
            ->where('name', $event->porder_status)
            ->first(['id']);

        //  get previous status_state_id for same porder from orderdeliverypath table
        $orderdeliverypath = DB::table('orderdeliverypath')
            ->where('porder_id', $porder_id)
            ->orderby('id', 'desc')
            ->first(['statusstate_id']);

        //  it means, we already have atleast 1 entry/entryies in orderdeliverypath table
        //  it means we must increment 1 in path_no
        if ($orderdeliverypath != null) {
              if previous statustate (e.g. pending, m-processing1) and its direct subsequent
                New statusstate are same we will not insert new record   
            if ($orderdeliverypath->statusstate_id == $statusstate->id) {
                return;
                //  we have different status
            } else {
                //  we will insert a new record with $path_no++
                //  todo: max porder_id is not a good solution
                $path_no = DB::table('orderdeliverypath')
                    ->where('porder_id', $porder_id)
                    ->max('path_no');

                $path_no++;
            }
        }//else: we will insert path_no=1 because it is our first record in orderdeliverypath table

        //  if it exists, it will be initialized otherwise it will be null
        $delivery_id = DB::table('delivery')
            ->where('porder_id', $porder_id)
            ->max('id');

        //  Now Insert Record in orderdeliverypath table...
        $odp = new OrderDeliveryPath;
        $odp->porder_id = $porder_id;
        $odp->delivery_id = $delivery_id;
        $odp->path_no = $path_no;
        $odp->statusstate_id = $statusstate->id;

        //var_dump('porder_id' . $porder_id);
        var_dump('delivery_id' . $delivery_id);
        var_dump('path_no' . $path_no);
        var_dump('statusstate->id' . $statusstate->id);
        $odp->save();
        */
    }
}
