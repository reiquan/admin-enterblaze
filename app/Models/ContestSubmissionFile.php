<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContestSubmissionFile extends Model
{
    use HasFactory;

    public const TYPE_IMAGE = 'image';
    public const TYPE_VIDEO = 'video';
    public const TYPE_AUDIO = 'audio';
    public const TYPE_PDF = 'pdf';
    public const TYPE_DOCUMENT = 'document';
    public const TYPE_THUMBNAIL = 'thumbnail';
    public const TYPE_PORTFOLIO = 'portfolio';
    public const TYPE_REFERENCE = 'reference';

    protected $fillable = [
        'contest_submission_id',
        'file_type',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'sort_order',
        'is_primary',
    ];

    protected $casts = [
        'file_size' => 'integer',
        'sort_order' => 'integer',
        'is_primary' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function contestSubmission()
    {
        return $this->belongsTo(ContestSubmission::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isImage(): bool
    {
        return $this->file_type === self::TYPE_IMAGE;
    }

    public function isVideo(): bool
    {
        return $this->file_type === self::TYPE_VIDEO;
    }

    public function isAudio(): bool
    {
        return $this->file_type === self::TYPE_AUDIO;
    }

    public function isPdf(): bool
    {
        return $this->file_type === self::TYPE_PDF;
    }

    public function isPrimary(): bool
    {
        return $this->is_primary;
    }

    public function markAsPrimary(): void
    {
        static::query()
            ->where('contest_submission_id', $this->contest_submission_id)
            ->whereKeyNot($this->getKey())
            ->update([
                'is_primary' => false,
            ]);

        $this->update([
            'is_primary' => true,
        ]);
    }

    public function formattedFileSize(): string
    {
        $bytes = $this->file_size ?? 0;

        if ($bytes >= 1_073_741_824) {
            return number_format($bytes / 1_073_741_824, 2) . ' GB';
        }

        if ($bytes >= 1_048_576) {
            return number_format($bytes / 1_048_576, 2) . ' MB';
        }

        if ($bytes >= 1_024) {
            return number_format($bytes / 1_024, 2) . ' KB';
        }

        return $bytes . ' bytes';
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    public function scopeImages($query)
    {
        return $query->where('file_type', self::TYPE_IMAGE);
    }

    public function scopeVideos($query)
    {
        return $query->where('file_type', self::TYPE_VIDEO);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}