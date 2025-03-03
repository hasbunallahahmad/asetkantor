<?php

namespace App\Console\Commands;

use App\Models\PembayaranStnk;
use App\Models\User;
use App\Notifications\PembayaranStnkExpiryNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckPembayaranStnkExpiryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pembayaran-stnk:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for upcoming STNK and TNKB payment expirations and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->info('Checking for upcoming STNK and TNKB expirations...');

        // Check for documents expiring in 30, 14, and 7 days
        $checkDays = [30, 14, 7];

        foreach ($checkDays as $days) {
            $expiryDate = Carbon::now()->addDays($days)->startOfDay();

            $expiringStnks = PembayaranStnk::query()
                ->whereDate('berlaku_hingga', $expiryDate->format('Y-m-d'))
                ->get();

            $this->info("Found " . $expiringStnks->count() . " documents expiring in $days days");

            // Notify admin users
            if ($expiringStnks->count() > 0) {
                $admins = User::where('is_admin', true)->get();

                foreach ($expiringStnks as $stnk) {
                    foreach ($admins as $admin) {
                        $admin->notify(new PembayaranStnkExpiryNotification($stnk, $days));
                        $this->info("Notification sent to {$admin->name} for {$stnk->kendaraan->nomor_plat}");
                    }
                }
            }
        }
        $this->info('Expiry check completed!');

        return Command::SUCCESS;
    }
}
