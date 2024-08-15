<?php

namespace App\Support;

trait Tenantable
{
    /**
     * Boot the tenantable trait for a model.
     */
    public static function bootTenantable(): void
    {
        static::addGlobalScope(new TenantableScope);

        static::saving(function ($model) {
            if (session()->has('tenant_id')) {
                $model->tenant_id = session('tenant_id');
            }
        });
    }

    /**
     * Get the fully qualified "tenant id" column.
     */
    public function getQualifiedTenantIdColumn(): string
    {
        return $this->qualifyColumn('tenant_id');
    }
}
