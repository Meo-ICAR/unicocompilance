<?php
// app/Jobs/UploadReceiptToUnicoDoc.php
class UploadReceiptToUnicoDoc implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public AmlSosReport $report,
        public string $filePath
    ) {}

    public function handle(UnicoDocService $service): void
    {
        // Se l'API di UnicoDoc fallisce, Laravel riproverà in automatico
        // in base alle configurazioni della coda (es. 3 tentativi, poi failed_jobs)
        $service->storeFiuReceipt($this->report, $this->filePath);
    }
}
