<?php

/**
 * SCOPO: Endpoint API per ricevere nuove richieste da UnicoDoc e smistarle.
 * PATH: app/Http/Controllers/Api/V1/UnicoDocIntegrationController.php
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Integration\RequestSorterService;
use Illuminate\Http\Request;

class UnicoDocIntegrationController extends Controller
{
    public function __construct(
        private RequestSorterService $sorter
    ) {}

    /**
     * POST /api/v1/integration/incoming-request
     */
    public function handleIncoming(Request $request)
    {
        // Valida che la richiesta arrivi effettivamente da UnicoDoc (es. tramite un Signature Header)

        $payload = $request->validate([
            'unicodoc_id' => 'required|integer',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'metadata' => 'array'  // Contiene info come 'sender_type', 'category_suggestion', ecc.
        ]);

        // Smista la richiesta
        $result = $this->sorter->classifyAndStore($payload);

        return response()->json([
            'status' => 'success',
            'routed_to' => $result['target_register'],
            'record_id' => $result['record_id']
        ]);
    }
}
