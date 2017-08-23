<?php

namespace App\Console\Commands;

use App\Order;
use Illuminate\Console\Command;

class UpdateNewspaperFundraising extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gd:update-newspaper-fundraising';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $orders = Order::where('polygraphy_type','newspaper1');

        $this->line('Будет обработано заказов: ' . $orders->count());

        foreach ($orders->get() as $order) {
            $poly = $order->polygraphy_approved();
            if ($poly->is_fundraising_finished == 'true') {
                if ($order->status == 'approved') {
                    $order->status = 'fundraising_finished';
                    $this->info("Статус обновлён с approved на fundraising_finished для заказа #{$order->id}");
                } else {
                    $this->error("Статус заказа #{$order->id} уже {$order->status}");
                }
            } else {
                $this->info("Команда ещё не собрала деньги на заказ #{$order->id}");
            }
        }
    }
}
