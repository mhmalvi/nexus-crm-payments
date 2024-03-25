<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Company;
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
    public function handle()
    {
        $company = Company::where('active', 1)->get();
        foreach ($company as $company) {
            if ($company->package == "trial") {
                $date = $company->end_date;
                $date_one = Carbon::parse($date)->subDays(1);
                $date_three = Carbon::parse($date)->subDays(3);
                $date_seven = Carbon::parse($date)->subDays(7);
                if (Carbon::now() == $date_three) {
                    Mail::to($company->business_email)->queue(new TrialPeriodMail($company->end_date));
                } else if (Carbon::now() == $date_seven) {
                    Mail::to($company->business_email)->queue(new TrialPeriodMail($company->end_date));
                } else if (Carbon::now() == $date_one) {
                    Mail::to($company->business_email)->queue(new TrialPeriodMail($company->end_date));
                } else if (Carbon::now() == $date) {
                    Mail::to($company->business_email)->queue(new TrialPeriodMail($company->end_date));
                }
                if (isset($company->end_date) && Carbon::now() > $company->end_date) {
                    $company->active = 2;
                    $company->save();
                }
            }
        }
    }
}
