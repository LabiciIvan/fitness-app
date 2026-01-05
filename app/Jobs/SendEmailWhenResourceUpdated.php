<?php

namespace App\Jobs;

use App\Mail\ResourceUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendEmailWhenResourceUpdated implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $email, public string $resource, public array $resourceFields, public string $resourceId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new ResourceUpdated($this->email, ucfirst($this->resource), $this->resourceFields, $this->resourceId));
    }
}
