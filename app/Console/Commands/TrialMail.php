<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Mail\TrialPeriodMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TrialMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:trial-mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(Request $request)
    {
        $ip = $request->ip();
        // $ip="119.18.3.81";
        // dd($ip);
        // $url = 'http://ip-api.com/json/' . $ip;
        // $tz = file_get_contents($url);
        // $tz = json_decode($tz, true)['timezone'];
        // // dd($tz);
        // $zone = json_encode(Carbon::now($tz));
        // // dd(Carbon::now($tz)->date);
        // $time = substr($zone, 12, 13);
        // // dd($time);
        // $time_str = substr($time, 0, 8);
        // // dd($time_sub);
        // $date_str = substr($zone, 1, 10);
        // // dd($sub_str);
        // $date_time_str = $date_str . ' ' . $time_str;
        // dd($date_time_str);
        // dd(Carbon::parse($tz)->format("Y-m-d H:i:s"));
        $company = Company::where('active', 1)->get();
        foreach ($company as $company) {
            if ($company->package == "trial") {
                $date = $company->end_date;
                // $date_one = Carbon::parse($date)->subDays(1);
                // $date_three = Carbon::parse($date)->subDays(3);
                // $date_seven = Carbon::parse($date)->subDays(7);

                print_r('end date');

                $end_date = Carbon::parse($date);
                // $date = json_encode($date->timezone($tz));
                print_r($end_date = $end_date->format("Y-m-d H:i:s"));
                // $date_three = json_encode($date_three->timezone($tz));
                // $date_seven = json_encode($date_seven->timezone($tz));
                print_r('curr date');
                $current_time = Carbon::now()->addHours(6);
                $current_time = $current_time->timezone($tz);
                print_r($current_time = json_encode($current_time));
                // print_r('date one');
                // $date_one = json_encode($date_one->timezone($tz));
                // if ($current_time == $date_three) {
                //     Mail::to($company->business_email)->send(new TrialPeriodMail($company->end_date, 3));
                // } else if ($current_time == $date_seven) {
                //     Mail::to($company->business_email)->send(new TrialPeriodMail($company->end_date, 7));
                // } else if (
                //     $current_time >= $date_one
                // ) {
                //     print_r('true');
                //     Mail::to($company->business_email)->send(new
                //         TrialPeriodMail($company->end_date, 1));
                // } else if ($current_time == $date) {
                //     Mail::to($company->business_email)->send(new TrialPeriodMail($company->end_date, 0));
                // }
                if (
                    isset($company->end_date) && $current_time >
                    $company->end_date
                ) {
                    $company->active = 2;
                    $company->subscription_id = "";
                    $company->save();
                }
            }
        }
    }
}
