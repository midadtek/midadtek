<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TCG\Voyager\Facades\Voyager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        date_default_timezone_set('Europe/Istanbul');
        Voyager::addAction(\App\Actions\QuantityAction::class);
        Voyager::addAction(\App\Actions\InvoiceAction::class);
        Voyager::addAction(\App\Actions\ReceiptAction::class);
        Voyager::addAction(\App\Actions\TransferAction::class);
        Voyager::addAction(\App\Actions\StepAction::class);

    }
}
