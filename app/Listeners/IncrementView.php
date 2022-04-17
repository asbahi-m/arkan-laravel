<?php

namespace App\Listeners;

use App\Events\Viewer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\View;

class IncrementView
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
     * @param  \App\Events\Viewer  $event
     * @return void
     */
    public function handle(Viewer $event)
    {
        View::create([
            'view_model' => class_basename($event->viewer),
            'view_id' => $event->viewer->id,
            'visitor' => session('_token'),
            'viewed_at' => now(),
        ]);
    }
}
