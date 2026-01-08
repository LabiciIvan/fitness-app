<?php

namespace App\Console\Commands;

use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Console\Command;
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

        $enrollments = Program::with('enrollments')->whereHas('enrollments')->get();

        foreach($enrollments as $enrollment) {
            $days = $enrollment['schedule']['days'];

            foreach ($days as $key => $day) {
                if ($day === $currentDay) {
                    $this->info('Enrollment: ' . $enrollment['name'] .  ' (' . $enrollment['id'] . ')' . ' will start today.');

                    foreach ($enrollment['enrollments'] as $enrolledUser) {
                        $this->info('Notification to be sent to: ' . $enrolledUser['email']);
                        Notification::create([
                            'details' => 'Your enrollment into program: ' . $enrollment['name'] . ' will start today.',
                            'action' => $enrollment['id'],
                            'user_id' => $enrolledUser['id'],
                        ]);
                    }
                }
            }
        }
        
        $this->info('The command was successful!');
    }
}
