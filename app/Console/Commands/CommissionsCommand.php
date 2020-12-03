<?php

namespace App\Console\Commands;

use App\Jobs\SendMailToSupplierAskingCommissions;
use App\Models\User;
use Illuminate\Console\Command;

class CommissionsCommand extends Command
{
    protected $signature = 'email:commissions';

    public function handle()
    {
        $suppliers = User::where('role_id', config('setting.supplier_id'))->get();
        foreach ($suppliers as $supplier) {
            SendMailToSupplierAskingCommissions::dispatch($supplier);
        }
    }
}
