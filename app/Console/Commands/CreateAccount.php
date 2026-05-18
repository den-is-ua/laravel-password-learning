<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use App\Models\Account;


#[Signature('account:create')]
#[Description('Command description')]
class CreateAccount extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
       $name = text('Put name');
       
       $account = Account::create(['name' => $name]);
       
       $this->info("Account has been created: {$account->name}");
    }
}
