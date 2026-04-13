# UnicoCompliance — Application Architecture & Vibe Coding Spec

> **Specification Version:** 1.0
> **Domain:** Regulatory Compliance & Risk Management
> **Framework:** Laravel 13, Filament 5.4, PHP 8.4
> **Integration:** Operates alongside `db_bpm` (Operations) and `db_unicodoc` (Document Management) on the same MySQL server.

## 0. AI Vibe Coding Strict Constraints

**CRITICAL INSTRUCTIONS FOR AI AGENT:**

1. **Connection Routing:** All local migrations, factories, and models MUST use `protected $connection = 'mysql_compliance';`.
2. **Cross-Database Relations:** Do NOT create physical Foreign Keys targeting `db_bpm` or `db_unicodoc` in migrations. Use logical indexes (e.g., `$table->char('company_id', 36)->index();`).
3. **Model Proxies:** To read data from the BPM or UnicoDoc, create Proxy Models in `app/Models/External/BPM/` and `app/Models/External/UnicoDoc/` defining their respective `$connection` and `$table`.
4. **Immutability:** Compliance data is highly sensitive. All models MUST use Soft Deletes.
5. **Audit Trail:** Use `spatie/laravel-activitylog` on ALL models to track `created`, `updated`, `deleted` events. Log the `causer_id` (the BPM user making the change).
6. **Enums:** Use native PHP 8.4 Enums for all status and category fields.

---

## 1. Database Topology

The application relies on `db_unicocompliance` but queries sibling databases for context:

- `db_bpm`: Source of truth for `users`, `companies`, `employees`, `agents`.
- `db_unicodoc`: Source of truth for physical files (`documents`, `request_registries`).

---

## 2. Core Data Dictionary (Migration Schemas)

### A. Privacy & Security Registers

**`gdpr_data_breaches`**

- `id`: BigIncrements
- `company_id`: char(36) [Index -> db_bpm]
- `incident_date`: datetime
- `discovery_date`: datetime
- `nature_of_breach`: string (Enum: unauthorized_access, data_loss, ransomware, etc.)
- `subjects_affected_count`: integer
- `is_notified_to_authority`: boolean
- `notification_date`: datetime (nullable)
- `containment_measures`: text
- `status`: string (Enum: investigating, contained, closed)

**`gdpr_dsr_requests` (Accesso e Rettifica Privacy)**

- `id`: BigIncrements
- `company_id`: char(36) [Index -> db_bpm]
- `request_type`: string (Enum: access, rectification, erasure, portability)
- `subject_name`: string
- `received_at`: datetime
- `due_date`: datetime (received_at + 30 days)
- `unicodoc_request_id`: unsignedBigInteger (nullable) [Index -> db_unicodoc.request_registries]
- `status`: string (Enum: pending, extended, fulfilled, rejected)

### B. Financial & Anti-Money Laundering (AML) Registers

**`aml_sos_reports` (Segnalazioni Operazioni Sospette)**

- `id`: BigIncrements
- `company_id`: char(36) [Index -> db_bpm]
- `agent_id`: char(36) [Index -> db_bpm.users/agents]
- `practice_reference`: string (nullable) [Index -> db_bpm.practices]
- `suspicion_indicators`: json (Array of Bank of Italy anomaly codes)
- `internal_evaluation`: text
- `forwarded_to_fiu`: boolean (Inviata all'UIF)
- `fiu_protocol_number`: string (nullable)
- `status`: string (Enum: drafted, evaluating, reported, archived)

### C. Corporate Governance & Quality Registers

**`complaint_registry` (Reclami)**

- `id`: BigIncrements
- `company_id`: char(36) [Index -> db_bpm]
- `complaint_number`: string (unique)
- `complainant_name`: string
- `category`: string (Enum: delay, behavior, privacy, fraud)
- `description`: text
- `financial_impact`: decimal(10,2) (nullable)
- `status`: string (Enum: open, investigating, resolved, rejected)

**`training_registry` (Formazione Obbligatoria IVASS/OAM/GDPR)**

- `id`: BigIncrements
- `user_id`: unsignedBigInteger [Index -> db_bpm.users]
- `course_name`: string
- `regulatory_framework`: string (Enum: ivass, oam, gdpr, safety)
- `completed_at`: date
- `valid_until`: date (nullable)
- `certificate_document_id`: uuid (nullable) [Index -> db_unicodoc.documents]

**`conflict_of_interest_registry`**

- `id`: BigIncrements
- `user_id`: unsignedBigInteger [Index -> db_bpm.users]
- `conflict_description`: text
- `mitigation_strategy`: text
- `approved_by_compliance_at`: datetime (nullable)

---

## 3. Cross-Application Integration Patterns

### 3.1 Fetching Documents (Integration with UnicoDoc)

If a compliance officer needs to attach the FIU (UIF) receipt to an `aml_sos_report`, the file is physically stored in UnicoDoc.
**Agent Instruction:** Use a Filament Action to trigger a REST API call to UnicoDoc (`POST unicodoc.internal/api/v1/store-file`) returning the `document_id`, which is then saved in `aml_sos_reports.receipt_document_id`.

### 3.2 Fetching Entities (Integration with BPM)

To display the Agent's name in the `aml_sos_reports` Filament table:
**Agent Instruction:**

```php
// app/Models/External/BPM/Agent.php
class Agent extends Model {
    protected $connection = 'mysql_bpm';
    protected $table = 'users'; // or 'agents'
}

// app/Models/AmlSosReport.php
public function agent() {
    return $this->belongsTo(\App\Models\External\BPM\Agent::class, 'agent_id');
}
```
