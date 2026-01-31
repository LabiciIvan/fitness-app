<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Program;
use Illuminate\Console\Command;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class NotifyUserBeforeProgramStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends notification to all users which are enrolled into a program which starts today.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $currentDay = $now->isoWeekday();

        $enrollments = Program::with(['enrollments', 'enrolled'])->whereHas('enrollments')->whereHas('enrolled')->get();

        foreach($enrollments as $enrollment) {
            $days = $enrollment['schedule']['days'];

            foreach ($days as $key => $day) {
                if ($day === $currentDay) {
                    $this->info('Enrollment: ' . $enrollment['name'] .  ' (' . $enrollment['id'] . ')' . ' will start today.');

                    foreach ($enrollment['enrolled'] as $enrolledUser) {
                        $this->info('Notification to be sent to: ' . $enrolledUser['email']);

                        NotificationService::notify(
                            userId: $enrolledUser['id'],
                            type: 'program.reminder',
                            data: [
                                'program' => $enrollment['name'],
                            ],
                            notifiable: $enrollment
                        );
                    }
                }
            }
        }
        
        $this->info('The command was successful!');
    }
}
