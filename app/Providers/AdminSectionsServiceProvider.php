<?php

namespace App\Providers;

use SleepingOwl\Admin\Providers\AdminSectionsServiceProvider as ServiceProvider;

class AdminSectionsServiceProvider extends ServiceProvider
{

    /**
     * @var array
     */
    protected $sections = [
        \App\Models\User::class => 'App\Http\Sections\Users',
        \App\Models\Page::class => 'App\Http\Sections\Page',
//        \App\Models\BlogPost::class => 'App\Http\Sections\BlogPost',
        \App\Models\Role::class => 'App\Http\Sections\Role',
        \App\Models\Country::class => 'App\Http\Sections\Country',
        \App\Models\Language::class => 'App\Http\Sections\Language',
        \App\Models\Car::class => 'App\Http\Sections\Car',
        \App\Models\VehicleBodyType::class => 'App\Http\Sections\VehicleBodyType',
        \App\Models\Routes::class => 'App\Http\Sections\Routes',
        \App\Models\Partner::class => 'App\Http\Sections\Partner',
        \App\Models\Content::class => 'App\Http\Sections\Content',
        \App\Models\Place::class => 'App\Http\Sections\Place',
        \App\Models\ExchangeRate::class => 'App\Http\Sections\ExchangeRate',
        \App\Models\Currency::class => 'App\Http\Sections\Currency',
        \App\Models\RouteOrder::class => 'App\Http\Sections\RouteOrder',
    ];

    /**
     * Register sections.
     *
     * @param \SleepingOwl\Admin\Admin $admin
     * @return void
     */
    public function boot(\SleepingOwl\Admin\Admin $admin)
    {
    	//

        parent::boot($admin);
    }
}
