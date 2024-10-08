<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\DB;

class DeleteExpiredTokens extends Command
{
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-expired-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    
    protected $description = 'Delete expired Sanctum tokens';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        //
        DB::table('personal_access_tokens')->where('expires_at', '<', now())->delete();
        $subs = DB::table('subscribers')->whereNotNull('remember_token')->get();
        foreach($subs as $sub) {
            $sub->remember_token = '';
            $sub->save();
        }
        $this->info('Expired tokens have been deleted.');
    }
}
