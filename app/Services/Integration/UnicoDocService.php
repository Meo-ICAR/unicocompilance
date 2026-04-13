<?php

namespace App\Services\Integration;

use App\Enums\AmlReportStatus;
use App\Models\AmlSosReport;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

readonly class UnicoDocService
{
    public function __construct(
        private string $unicoDocBaseUrl = 'http://unicodoc.internal/api/v1',
        private string $apiToken = ''  // Idealmente iniettato via config
    ) {}

    /**
     * Invia la ricevuta UIF a UnicoDoc e salva il riferimento.
     */
    public function storeFiuReceipt(AmlSosReport $report, UploadedFile $file, string $causerId): AmlSosReport
    {
        // 1. Chiamata REST a db_unicodoc
        $response = Http::withToken($this->apiToken)
            ->attach('file', $file->getContent(), $file->getClientOriginalName())
            ->post("{$this->unicoDocBaseUrl}/store-file", [
                'category' => 'aml_receipt',
                'reference_id' => $report->id,
            ]);

        if ($response->failed()) {
            throw new \Exception('Errore integrazione UnicoDoc: ' . $response->body());
        }

        $documentId = $response->json('data.document_id');

        // 2. Aggiornamento Logico (Strict Constraint: Spatie Activity Log lo intercetta)
        activity()
            ->causedBy($causerId)  // Specifica BPM User
            ->performedOn($report)
            ->log('Ricevuta UIF caricata su UnicoDoc e collegata alla pratica');

        $report->update([
            'receipt_document_id' => $documentId,
            'status' => AmlReportStatus::REPORTED,  // PHP 8.4 Enum
        ]);

        return $report;
    }
}
