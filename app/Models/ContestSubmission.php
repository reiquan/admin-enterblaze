<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContestSubmission extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'event_id',
        'user_id',

        'submission_title',
        'submission_description',
        'submission_category',

        'submission_thumbnail',
        'submission_file',
        'submission_url',

        'submission_status',

        'rules_accepted',
        'original_work_confirmed',
        'public_display_permission',

        'submitted_at',

        'review_notes',
        'rejection_reason',
    ];

    protected $casts = [
        'rules_accepted' => 'boolean',
        'original_work_confirmed' => 'boolean',
        'public_display_permission' => 'boolean',

        'submitted_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function submit(): void
    {
        $this->update([
            'submission_status' => 'submitted',
            'submitted_at' => now(),
        ]);
    }

    public function approve(): void
    {
        $this->update([
            'submission_status' => 'approved',
        ]);
    }

    public function reject(?string $reason = null): void
    {
        $this->update([
            'submission_status' => 'rejected',
            'rejection_reason' => $reason,
        ]);
    }

    public function isDraft(): bool
    {
        return $this->submission_status === 'draft';
    }

    public function isSubmitted(): bool
    {
        return $this->submission_status === 'submitted';
    }

    public function isApproved(): bool
    {
        return $this->submission_status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->submission_status === 'rejected';
    }

    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSubmitted($query)
    {
        return $query->where('submission_status', 'submitted');
    }

    public function scopeApproved($query)
    {
        return $query->where('submission_status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('submission_status', 'rejected');
    }

    public function scopeDraft($query)
    {
        return $query->where('submission_status', 'draft');
    }
    /**
     * All files attached to this submission.
     */
    public function files()
    {
        return $this->hasMany(ContestSubmissionFile::class)
            ->orderBy('sort_order');
    }

    /**
     * Primary thumbnail for the submission.
     */
    public function primaryThumbnail()
    {
        return $this->hasOne(ContestSubmissionFile::class)
            ->where('file_type', ContestSubmissionFile::TYPE_THUMBNAIL)
            ->where('is_primary', true);
    }

    /**
     * All thumbnail files.
     */
    public function thumbnails()
    {
        return $this->hasMany(ContestSubmissionFile::class)
            ->where('file_type', ContestSubmissionFile::TYPE_THUMBNAIL)
            ->orderBy('sort_order');
    }
}