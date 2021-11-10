<?php

namespace App\Console\Commands;

use App\Mail\ContactUsMail;
use App\Mail\OrderNotifyMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;

class RedisSubscribe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'redis:subscribe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe to a Redis channel';

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
        // Redis::subscribe(['createOrder'], function ($message) {
        //     $mail = env('MAIL_USERNAME');
        //     $message = json_decode($message, true);
        //     Mail::to($mail)->send(new OrderNotifyMail($message['orderId']));

        //     echo "新訂單 ID : " . $message['orderId'].", ";
        // });

        // Redis::subscribe(['contactUs'],function($message){
        //     echo $message;
        // });

        Redis::psubscribe(['*'], function ($message, $channel) {
            $prefix=strtolower(env('APP_NAME'))."_database_";
            $mail = env('MAIL_USERNAME');
            if ($channel == $prefix.'createOrder') {
                $message = json_decode($message, true);
                Mail::to($mail)->send(new OrderNotifyMail($message['orderId']));

                echo "新訂單 ID : " . $message['orderId'] . ", ";
            }else if($channel == $prefix.'contactUs'){
                Mail::to($mail)->send(new ContactUsMail($message));
                echo($message);
            }

            echo "； channel : ".$channel."||";
        });
    }
}
