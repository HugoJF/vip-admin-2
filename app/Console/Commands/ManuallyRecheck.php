<?php

namespace App\Console\Commands;

use App\Order;
use Illuminate\Console\Command;

class ManuallyRecheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:recheck {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger manual order recheck';

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
        $id = $this->argument('id');

        /** @var Order $order */
        $order = Order::findOrFail($id);

        $order->recheck();

        $this->info("Order $order->id rechecked");
    }
}
