<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Documents extends Model
{
    // Nama tabel jika tidak mengikuti konvensi Laravel (bentuk jamak lowercase)
    protected $table = 'documents';

    // Field yang bisa diisi secara mass-assignment
    protected $fillable = [
        'name',
        'original_name',
        'file_path',
        'file_type',
        'uploaded_at',
        'uploaded_by',
        'updated_by',
        'bidang',
    ];

    // Casting atribut ke tipe data tertentu
    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    /**
     * Relasi ke user yang mengupload dokumen
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relasi ke user yang terakhir mengupdate dokumen
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
