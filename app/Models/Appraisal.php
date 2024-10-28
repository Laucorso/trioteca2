<?php

namespace App\Models;

use App\Events\AppraisalStatusUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Appraisal extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    public static function createRules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'property_address' => 'required|string|max:255',
            'property_price' => 'nullable|numeric|min:0',
            'comments' => 'nullable|string|max:1000',
            'status' => 'required|in:Solicitado,En proceso,Tasación completada,Rechazado',
            'next_appointment' => 'nullable|date|after_or_equal:today',
        ];
    }

    // Reglas de validación para la actualización
    public static function updateRules()
    {
        return [
            'client_id' => 'nullable|sometimes|required|exists:clients,id',
            'property_address' => 'nullable|sometimes|required|string|max:255',
            'property_price' => 'nullable|sometimes|nullable|numeric|min:0',
            'comments' => 'nullable|sometimes|nullable|string|max:1000',
            'status' => 'nullable|sometimes|required|in:Solicitado,En proceso,Tasación completada,Rechazado',
            'next_appointment' => 'nullable|sometimes|nullable|date|after_or_equal:today',
        ];
    }

    // when changing appraisal status automatically sent email to client
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($appraisal) {
            $isNew = !$appraisal->exists;

            // event when create new appraisal or when status changed
            if ($isNew || $appraisal->isDirty('status')) {
                event(new AppraisalStatusUpdated($appraisal->toArray()));
            }
        });
    }

    public function managedByUser()
    {
        return $this->belongsTo(User::class, 'managed_by_user');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
