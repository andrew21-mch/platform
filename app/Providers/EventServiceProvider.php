<?php

namespace Ushahidi\App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Ushahidi\App\Events\Event::class => [
            \Ushahidi\App\Listeners\EventListener::class,
        ],
        \Ushahidi\App\Events\SendToHDXEvent::class => [
            \Ushahidi\App\Listeners\SendToHDXEventListener::class,
        ],
    ];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        \Ushahidi\App\EventSubscriber::class,
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
