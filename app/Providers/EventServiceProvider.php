<?php

namespace App\Providers;
use App\Authtracker;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Session;

use App\Models\POrder;
use App\Events\PorderStatusChanged;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
	protected $listen = [
		'App\Events\PorderStatusChanged' => [
			'App\Listeners\InsertOrderDeliveryPath'
		],
	];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        /* $events->listen('auth.attempt', function () {
    
        });*/
        
		try {
			$events->listen('auth.login', function ($user) {
			if (!is_null($user)) {
				$authtracker = new Authtracker();
				$authtracker->user_id = $user->id;
				$authtracker->status = 'login';
				$authtracker->updated_at = Carbon::now();
				$authtracker->save();
			}
        });
		} catch (\Exception $e) {
            // Do nothing!!
		}

		try {
			$events->listen('auth.logout', function ($user) {
			if (!is_null($user)) {
				$authtracker = new Authtracker();
				$authtracker->user_id = $user->id;
				$authtracker->status = 'logout';
				$authtracker->created_at = Carbon::now();
				$authtracker->updated_at = Carbon::now();
				$authtracker->save();
			}
        });
		} catch (\Exception $e) {
            Auth::logout(); 
		}

		POrder::saved(function ($porder) {
//            $columns = $porder->getDirty();
//
//            foreach ($columns as $column => $newValue) {
//                // One of the changed columns.
//                if ($column !== 'status')
			event(new PorderStatusChanged($porder->id, $porder->status));
			//}
		});

		POrder::updated(function ($porder) {
//            $columns = $porder->getDirty();
//
//            foreach ($columns as $column => $newValue) {
//                // One of the changed columns.
//                if ($column !== 'status')
			event(new PorderStatusChanged($porder->id, $porder->status));
			//}
		});
    }
}
