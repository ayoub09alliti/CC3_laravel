<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id', 'doctor_id', 'service_id',
        'appointment_date', 'appointment_time', 'status',
        'notes', 'doctor_notes', 'email_sent'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'email_sent' => 'boolean',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function scopeForDate($query, $date)
    {
        return $query->whereDate('appointment_date', $date);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'   => 'badge-warning',
            'confirmed' => 'badge-success',
            'cancelled' => 'badge-danger',
            'completed' => 'badge-info',
            default     => 'badge-secondary',
        };
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->appointment_date->format('d/m/Y');
    }
}