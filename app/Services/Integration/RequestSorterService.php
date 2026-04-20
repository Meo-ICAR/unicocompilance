<?php

/**
 * SCOPO: Analizzare la richiesta e smistarla nel registro corretto.
 * PATH: app/Services/Integration/RequestSorterService.php
 */

namespace App\Services\Integration;

use App\Models\COMPILANCE\AmlSosReport;
use App\Models\COMPILANCE\ComplaintRegistry;
use App\Models\COMPILANCE\GdprDsrRequest;

class RequestSorterService
{
    public function classifyAndStore(array $data): array
    {
        $text = strtolower($data['title'] . ' ' . ($data['description'] ?? ''));

        // 1. Logica di Smistamento GDPR
        if (str_contains($text, 'privacy') || str_contains($text, 'cancellazione') || str_contains($text, 'accesso dati')) {
            $record = GdprDsrRequest::create([
                'company_id' => $data['metadata']['company_id'] ?? null,
                'subject_name' => $data['metadata']['sender_name'] ?? 'Soggetto Ignoto',
                'request_type' => 'access',
                'received_at' => now(),
                'unicodoc_request_id' => $data['unicodoc_id'],
                'status' => 'pending'
            ]);
            return ['target_register' => 'gdpr_dsr', 'record_id' => $record->id];
        }

        // 2. Logica di Smistamento Reclami
        if (str_contains($text, 'reclamo') || str_contains($text, 'contestazione') || str_contains($text, 'disservizio')) {
            $record = ComplaintRegistry::create([
                'company_id' => $data['metadata']['company_id'] ?? null,
                'complaint_number' => 'REC-' . now()->format('Ymd') . '-' . $data['unicodoc_id'],
                'complainant_name' => $data['metadata']['sender_name'] ?? 'N/A',
                'description' => $data['description'],
                'category' => 'behavior',
                'status' => 'open'
            ]);
            return ['target_register' => 'complaints', 'record_id' => $record->id];
        }

        // 3. Fallback: Se non è compliance, potresti loggare o ignorare
        throw new \Exception('Richiesta non pertinente alla Compliance.');
    }
}
