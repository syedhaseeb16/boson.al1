<?php

namespace Botble\LanguageAdvanced\Providers;

use Botble\Base\Events\CreatedContentEvent;
use Botble\Base\Events\DeletedContentEvent;
use Botble\LanguageAdvanced\Listeners\AddDefaultTranslations;
use Botble\LanguageAdvanced\Listeners\DeletedContentListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        DeletedContentEvent::class => [
            DeletedContentListener::class,
        ],
        CreatedContentEvent::class => [
            AddDefaultTranslations::class,
        ],
    ];
}
