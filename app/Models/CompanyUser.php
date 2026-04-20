<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CompanyUser extends Pivot
{
    protected $table = 'company_user';

    protected $fillable = [
        'user_id',
        'company_id',
        'role',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'role' => 'user',
    ];

    // Constants for roles
    const ROLE_ADMIN = 'admin';
    const ROLE_MANAGER = 'manager';
    const ROLE_USER = 'user';
    const ROLE_VIEWER = 'viewer';

    const ROLES = [
        self::ROLE_ADMIN => 'Amministratore',
        self::ROLE_MANAGER => 'Manager',
        self::ROLE_USER => 'Utente',
        self::ROLE_VIEWER => 'Visualizzatore',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(\App\Models\PROFORMA\Company::class, 'company_id');
    }

    // Helper methods
    public function getRoleLabelAttribute(): string
    {
        return self::ROLES[$this->role] ?? ucfirst($this->role);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isManager(): bool
    {
        return $this->role === self::ROLE_MANAGER;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }

    public function isViewer(): bool
    {
        return $this->role === self::ROLE_VIEWER;
    }

    public function canManageUsers(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

    public function canManageCompany(): bool
    {
        return $this->isAdmin();
    }

    public function canViewAllData(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

    public function canEditCompanyData(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

    public function canViewReports(): bool
    {
        return $this->isAdmin() || $this->isManager() || $this->isUser();
    }

    public function getPermissionsAttribute(): array
    {
        $permissions = [];

        if ($this->isAdmin()) {
            $permissions[] = 'Gestione completa azienda';
            $permissions[] = 'Gestione utenti';
            $permissions[] = 'Visualizzazione tutti i dati';
            $permissions[] = 'Modifica dati azienda';
            $permissions[] = 'Accesso report';
        }

        if ($this->isManager()) {
            $permissions[] = 'Visualizzazione tutti i dati';
            $permissions[] = 'Modifica dati azienda';
            $permissions[] = 'Accesso report';
        }

        if ($this->isUser()) {
            $permissions[] = 'Accesso report';
        }

        if ($this->isViewer()) {
            $permissions[] = 'Visualizzazione limitata';
        }

        return $permissions;
    }

    // Scopes for querying
    public function scopeAdmin($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }

    public function scopeManager($query)
    {
        return $query->where('role', self::ROLE_MANAGER);
    }

    public function scopeUser($query)
    {
        return $query->where('role', self::ROLE_USER);
    }

    public function scopeViewer($query)
    {
        return $query->where('role', self::ROLE_VIEWER);
    }

    public function scopeCanManageUsers($query)
    {
        return $query->whereIn('role', [self::ROLE_ADMIN, self::ROLE_MANAGER]);
    }

    public function scopeCanManageCompany($query)
    {
        return $query->where('role', self::ROLE_ADMIN);
    }
}
