<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketStoreRequest;
use App\Http\Resources\TicketResource;
use App\Jobs\EnrichTicketWithAi;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function store(TicketStoreRequest $request)
    {
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'Open',
        ]);

        EnrichTicketWithAi::dispatch($ticket->id);

        return response()->json([
            'message' => 'Ticket Created',
            'id' => $ticket->id,
        ], 201);
    }

    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }
}
