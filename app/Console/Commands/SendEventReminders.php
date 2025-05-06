<?php

namespace App\Console\Commands;

use App\Models\Event;
use App\Notifications\SendEventNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SendEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-event-reminders';

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
        $events = Event::with('attendees.user')
                    ->whereBetween('start_time', [now(), now()->addDays(1)])
                    ->get();

        $eventCount = $events->count();
        $eventLabel = Str::plural('event', $eventCount);

        $events->each(
            fn ($event) => $event->attendees->each(
                fn ($attendee) => $attendee->user->notify(new SendEventNotification($event))
            )
        );

        $this->info("Found {$eventCount} {$eventLabel}");

    }
}
