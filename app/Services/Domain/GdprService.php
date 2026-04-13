<?php

/**
 * SCOPO: Servizio per la gestione logica delle richieste GDPR DSR (Accesso, Rettifica, ecc.).
 * PATH: app/Services/Domain/GdprService.php
 * CONSTRAINTS: Calcolo automatico scadenze e business logic isolata.
 */

namespace App\Services\Domain;

use App\Models\GdprDsrRequest;
use Carbon\Carbon;

readonly class GdprService
{
    /**
     * Registra una nuova richiesta DSR calcolando automaticamente la scadenza (+30 giorni).
     */
    public function registerDsrRequest(array $data, string $causerId): GdprDsrRequest
    {
        $receivedAt = Carbon::parse($data['received_at'] ?? now());

        $request = new GdprDsrRequest([
            'company_id' => $data['company_id'],
            'request_type' => $data['request_type'],
            'subject_name' => $data['subject_name'],
            'received_at' => $receivedAt,
            'due_date' => $receivedAt->copy()->addDays(30),  // Regola GDPR standard
            'status' => 'pending',
        ]);

        // Forza la tracciatura dell'utente che ha creato il record
        activity()
            ->causedBy($causerId)
            ->performedOn($request)
            ->log('Registrata nuova richiesta DSR');

        $request->save();

        return $request;
    }
}
