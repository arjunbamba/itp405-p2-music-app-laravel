<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Invoice;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // From InvoiceController: Lecture 03/22
        Gate::define('view-invoice', function(User $user, Invoice $invoice) { // Gates are functions; we give it a unique key (view invoice) and pass it a callback function and that gets the authenticated user and any additional data that we pass in (i.e. invoice). When we call Gate denies, it'll execute this callback function
            return $user->email === $invoice->customer->email;
        });

        Gate::before(function (User $user) {
            // return $user->isAdmin();  // 2 possible return values are true or false - DOES NOT WORK
            
            // 2 possible return values are true or NULL - Works because it sees NULL and continues to return NULL
            if ($user->isAdmin()) {
                return true;
            }
        });
    }
}
