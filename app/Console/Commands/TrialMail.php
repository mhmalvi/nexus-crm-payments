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
        $company = Company::all();
        foreach ($company as $company) {
            if ($company->package == "trial") {
                $date = $company->end_date;
                $date_three = Carbon::parse($date)->subDays(3);
                $date_seven = Carbon::parse($date)->subDays(7);
                // dd($company->business_email);

                if (Carbon::now() == $date_three) {
                    Mail::to($company->business_email)->queue(new TrialPeriodMail());
                } else if (Carbon::now() == $date_seven) {
                    Mail::to($company->business_email)->queue(new TrialPeriodMail());
                }
            }
        }
    }
}
