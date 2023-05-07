<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class BusinessTaxPaymentFunctionBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buildfunction:tax-business';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Functions to create table and update building owner when new tax data is imported';

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
     * @return int
     */
    public function handle()
    {
        // function and triggers to update grids & wardpl when jhe_buildings has changes
        DB::unprepared(Config::get('business-taxpayment-info.fnc_create_businesstaxpaymentstatus'));

        \Log::info("Functions to create table after import successfully!!");
        $this->info('Functions to create table after import successfully!!');

        return 0;
    }
}
