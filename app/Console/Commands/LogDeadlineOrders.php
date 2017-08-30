<?php

namespace App\Console\Commands;

use App\GdLogEntry;
use App\Order;
use Illuminate\Console\Command;

class LogDeadlineOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'log:deadline-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send notification to mainLog';

    /**
     * Create a new command instance.
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
        $orders = Order::where([
            'status' => 'fundraising_finished',
            ['status_changed_at', '>', 0],
            ['status_changed_at', '<', 'NOW() - INTERVAL 12 HOUR']
        ])->get();

        foreach ($orders as $order) {
            $log = GdLogEntry::where('arg_id', $order->id)
                ->where('type', 'order_deadline_12_hours')
                ->first();

            if (!$log) {
                $log = GdLogEntry::create([
                    'type' => 'order_deadline_12_hours',
                    'arg_id' => $order->id,
                    'user_id' => 1374,
                    'tg_bot_status' => 'inqueue',
                    'details' => json_encode([
                        'order_id' => $order->id,
                        'status_changed_at' => $order->status_changed_at,
                    ])
                ]);
            }
        }

    }
}
