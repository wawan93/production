<?php

namespace App\Console\Commands;

use App\Order;
use Illuminate\Console\Command;

class UpdatePolygraphyTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gd:update-polygraphy-teams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновить все polygraphy_approved, связанные с заказами и проставить им всем текущий состав команд';

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
        $orders = Order::where('status', '!=', 'cancelled');
        $this->line('Будет обработано заказов: ' . $orders->count());

        foreach ($orders->get() as $order) {
            $this->line('Обрабатывается заказ ' . $order->id);
            $poly = $order->polygraphy_approved();
            if (!$poly->members()) {
                $members = $order->team()->members();
                $poly->members_ids = implode(',', $members->pluck('id')->toArray());
                if ($poly->save()) {
                    $this->info('Обновлен polygraphy_approved #' . $poly->id);
                } else {
                    $this->error('Не удалось обновить polygraphy_approved #' . $poly->id);
                }
            } else {
                $this->info('Не нужно обновлять polygraphy_approved #' . $poly->id);
            }
        }
    }
}
