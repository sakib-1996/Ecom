<?php

namespace App\Console\Commands;

use App\Models\Discount;
use Illuminate\Console\Command;

class CheckDiscountTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-discount';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $discounts = Discount::where('status', 1)->get();
        foreach ($discounts as $discount) {
            $startDate = $discount->start_date;
            $endDate = $discount->end_date;

            if (now()->gte($startDate)) {
                $discount->update(['draft' => 1]);
            }

            if (now()->gt($endDate)) {
                $discount->update(['draft' => 0]);
            }
        }
    }
}
