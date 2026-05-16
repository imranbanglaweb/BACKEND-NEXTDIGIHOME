<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendMaintenanceReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $due = \App\Models\MaintenanceSchedule::with('vehicle','vendor','type')
            ->where('active', true)
            ->where(function($q){
                $q->whereNotNull('next_due_date')->whereDate('next_due_date','<=', now()->addDays(7));
            })->get();

        foreach($due as $s) {
            // send email to fleet manager or vendor
            \Mail::to('fleet@example.com')->send(new \App\Mail\MaintenanceDueMail($s));

            // create in-app notification or push
            // Notification::send($user, new MaintenanceDueNotification($s));

            // Optionally log
            \Log::info("Maintenance due notification sent for vehicle {$s->vehicle_id}");
        }
    }

}
