<?php

/**
 * SCOPO: Endpoint API consumato dal DB_BPM per verificare se un Agente è in regola.
 * PATH: app/Http/Controllers/Api/V1/AgentComplianceApiController.php
 * CONSTRAINTS: Ritorna dati chiari e veloci per non bloccare l'operatività del BPM.
 */

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\COMPILANCE\TrainingRegistry;
use Illuminate\Http\JsonResponse;

class AgentComplianceApiController extends Controller
{
    /**
     * GET /api/v1/compliance/agents/{agent_id}/training-status
     */
    public function trainingStatus(string $agentId): JsonResponse
    {
        // Verifica se esistono corsi obbligatori scaduti per questo utente
        $expiredCourses = TrainingRegistry::where('user_id', $agentId)
            ->where('valid_until', '<', today())
            ->get(['course_name', 'valid_until']);

        if ($expiredCourses->isNotEmpty()) {
            return response()->json([
                'is_compliant' => false,
                'message' => "L'agente ha formazione obbligatoria scaduta.",
                'expired_courses' => $expiredCourses
            ], 403);
        }

        return response()->json([
            'is_compliant' => true,
            'message' => 'Formazione in regola.'
        ], 200);
    }
}
