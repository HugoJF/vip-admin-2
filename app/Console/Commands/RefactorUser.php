<?php

namespace App\Console\Commands;

use App\Services\OrderRefactoringService;
use App\User;
use Illuminate\Console\Command;

class RefactorUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:refactor {steamid}';

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
        $steamid = steamid64($this->argument('steamid'));
        $user = User::query()->where('steamid', $steamid)->first();

        if (!$user) {
            $this->warn("There are no users with $steamid");
        }

        /** @var OrderRefactoringService $service */
        $service = app(OrderRefactoringService::class);

        if ($user) {
            $service->refactorUser($user);
        } else {
            $service->refactorSteamid($steamid);
        }

        $this->info('Done refactoring...');
    }
}
