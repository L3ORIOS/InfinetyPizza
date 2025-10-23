<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;


use App\Mail\OrderSummaryMail;
use App\Models\Pedido;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Pedido $pedido)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $pedido = $this->pedido->load(['user:id,name,email', 'pizza:id,name,price', 'pizza.ingredientes:id,name']);

        Mail::to($pedido->user->email)
            ->send(new OrderSummaryMail($pedido));
    }
}
