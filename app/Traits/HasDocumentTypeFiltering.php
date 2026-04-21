<?php

namespace App\Traits;

use App\Models\DOC\DocumentType;
use App\Models\PROFORMA\Client;
use App\Models\PROFORMA\Clienti;
use App\Models\PROFORMA\Fornitore;
use App\Models\PROFORMA\Pratiche;

trait HasDocumentTypeFiltering
{
    /**
     * Get filtered document types based on record type
     */
    protected function getFilteredDocumentTypes($record): array
    {
        $targetType = match (true) {
            $record instanceof Fornitore => 'fornitore',
            $record instanceof Clienti => 'istituto',
            $record instanceof Client => 'consulente',
            $record instanceof Practiche => 'pratica',
            default => 'company'
        };

        return DocumentType::where("is_{$targetType}", true)
            ->orWhere('is_company', true)
            ->pluck('name', 'id')
            ->sort()
            ->toArray();
    }

    /**
     * Get target type from record
     */
    protected function getTargetType($record): string
    {
        return match (true) {
            $record instanceof Fornitore => 'fornitore',
            $record instanceof Clienti => 'istituto',
            $record instanceof Client => 'consulente',
            $record instanceof Practiche => 'pratica',
            default => 'company'
        };
    }

    /**
     * Get document type options for select field
     */
    protected function getDocumentTypeOptions($record, ?callable $get = null): array
    {
        return $this->getFilteredDocumentTypes($record);
    }
}
