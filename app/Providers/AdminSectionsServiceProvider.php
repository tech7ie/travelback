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
        \App\Models\BlogPost::class => 'App\Http\Sections\BlogPost',
        \App\Models\Role::class => 'App\Http\Sections\Role',
        \App\Models\Country::class => 'App\Http\Sections\Country',
        \App\Models\Language::class => 'App\Http\Sections\Language',
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
