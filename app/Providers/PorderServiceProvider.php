<?php

namespace App\Providers;
use DB;
use App\Models\POrder;
use Illuminate\Support\ServiceProvider;

class PorderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        POrder::updating(function($porder){

			$p = POrder::find($porder->id);
			if (isset($p) && (!empty($p))) {
				/* Squidster: NEXTGen previous path processing:
				 * Determine which path we had gone through */
				switch($porder->status) {
					case "b-returning":
					case "m-collected":
						// Update prev_m_approved
						$p->prev_m_approved = $porder->status;
						break;

					case "reviewed1":
					case "reviewed2":
					case "m-approved":
						// Update prev_completed
						$p->prev_completed = $porder->status;
						break;

					/*
					// Bypass rejected1, skip to next state, reviewed1
					case "rejected1":
						$p->status = "reviewed1";
						break;

					// Bypass rejected2, skip to next state, reviewed2
					case "rejected2":
						$p->status = "reviewed2";
						break;
					*/

					/*
					Scenario: b-collected but [Return] not clicked, so
					status-> completed after return timer expired. However
					prev variables are NOT populated, therefore MRT is not
					able to plot the path.
					*/
					case "completed":
						if (is_null($p->prev_m_approved) &&
							is_null($p->prev_completed)) {
							$p->prev_m_approved = "b-returning";
							$p->prev_completed = "m-approved";
						}
						break;
   					
					default:
				}
                // Update new data in records
				$p->save();
			}
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
