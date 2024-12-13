<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Kreait\Firebase\Contract\Database;
class SendRegisterEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:welcomemail {user_id}';

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
    public function __construct(Database $database)
    {
        parent::__construct();
        $this->database = $database;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_id = $this->argument('user_id');
        $user = \App\Models\User::find($user_id);
        if($user !=null){
            $name = $user->name;  
            $mailbody = view('emai_templates.registration_mail', compact( 'name'))->render();
            send_email($user->email,"Welcome Timex",$mailbody);
        }
    }
}