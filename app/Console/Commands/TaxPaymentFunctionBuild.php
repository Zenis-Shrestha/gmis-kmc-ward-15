<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

class TaxPaymentFunctionBuild extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'buildfunction:tax-bldg';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates Functions to create table when new tax data is imported';

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
        // function to create table
        DB::unprepared(Config::get('taxpayment-info.fnc_create_bldgtaxpaymentstatus'));
        DB::unprepared(Config::get('taxpayment-info.fnc_insrtupd_taxbuildowner'));

        \Log::info("Functions to create table and update bldg after import successfully!!");
        $this->info('Functions to create table and update bldg after import successfully!!');

        return 0;
    }
}
