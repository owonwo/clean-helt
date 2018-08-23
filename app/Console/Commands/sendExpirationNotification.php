<?php

namespace App\Console\Commands;

use App\Events\ProfileExpirationEvent;
use App\Models\ProfileShare;
use Illuminate\Console\Command;

class sendExpirationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiration:send {provider}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It sends notification to all provider telling them that their share will soon expire';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //We want to find all the profile shares that have a provider, All ProfileShares do have a provider;
        //We also have to consider the active status
        $profileShare = ProfileShare::all();
        $profileShare->each(function($item,$key){
            if($item->status == 1){
               dd(event(new ProfileExpirationEvent($item->patient,$item->provider)));
               return "Notifications sent to Providers Successfully";
            }else{
                return "No Profile share to send";
            }

        });


    }
}
