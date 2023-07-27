<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Order;
use App\Notifications\NewOrderNotification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    // Run the task every minute (adjust the schedule as needed)
    $schedule->call(function () {
        $latestOrder = Order::latest()->first();

        // Assuming you have a last_checked column on the admins table to store the last checked order ID
        $lastCheckedOrderID = auth()->guard('admin')->user()->last_checked;

        if ($latestOrder && $latestOrder->id > $lastCheckedOrderID) {
            // Send notification to the admin users using the OrderStatusNotification
            $admins = \App\Models\Admin::all();
            foreach ($admins as $admin) {
                $admin->notify(new NewOrderNotification());
            }

            // Update the last_checked column with the ID of the latest order
            auth()->guard('admin')->user()->update(['last_checked' => $latestOrder->id]);
        }
    })->everyMinute();
}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
