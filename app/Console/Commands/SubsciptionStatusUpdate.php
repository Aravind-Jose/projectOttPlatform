<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Carbon;

class SubsciptionStatusUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Users:subsciption-status-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the subscription status of the users after 30 days of subscription date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentDate = Carbon::now();
        $users = User::where('subscription', true)->get();
        foreach ($users as $user) {
            $subscriptionDate = Carbon::parse($user->subscriptionDate);
            
            $diff = $currentDate->diffInDays($subscriptionDate);
            if ($diff > 30) {
                $user->subscription = false;
                $user->save();
            }
            \Log::info($diff);
        }
    }
}
