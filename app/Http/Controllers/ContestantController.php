<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use App\Models\ContestSubmission;
use App\Models\ContestSubmissionFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Collection;

class ContestantController extends Controller
{
    //

    public function create(Request $request, $event_id){
    
        $event  = Event::find($event_id);
        // dd($contests->toArray());
        $step =1;
      
        // dd($tiers->toArray());
        // return view('users.tokens.index', compact('tiers'));
        return view('contests.create', compact('event', 'step'));
    }

    public function store(Request $request): View|RedirectResponse
    {
        $validated = $request->validate([
            'event_id' => ['required', 'exists:events,id'],

            'submission_title' => ['required', 'string', 'max:255'],
            'submission_category' => ['required', 'string', 'max:255'],
            'submission_description' => ['required', 'string'],
            'submission_url' => ['nullable', 'url', 'max:255'],

            'rules_accepted' => ['accepted'],
            'original_work_confirmed' => ['accepted'],
            'public_display_permission' => ['accepted'],
        ]);

        $contest_submission = ContestSubmission::create([
            'event_id' => $validated['event_id'],
            'user_id' => auth()->id(),
            'universe_id' => $validated['universe_id'] ?? null,

            'submission_title' => $validated['submission_title'],
            'submission_category' => $validated['submission_category'],
            'submission_description' => $validated['submission_description'],
            'submission_url' => $validated['submission_url'] ?? null,

            'submission_status' => ContestSubmission::STATUS_DRAFT,

            'rules_accepted' => true,
            'original_work_confirmed' => true,
            'public_display_permission' => true,
        ]);

        $step = 2;

        $event = Event::findOrFail($validated['event_id']);

        return view('contests.create', compact(
            'contest_submission',
            'event',
            'step'
        ));
    }
    
    public function update(
        Request $request,
        ContestSubmission $contest_submission
    ): View|RedirectResponse {
        abort_if(
            $contest_submission->user_id !== auth()->id(),
            403
        );

        $step = (int) $request->input('step');

        switch ($step) {
            case 2:
                $this->storeContestFile(
                    request: $request,
                    contestSubmission: $contest_submission,
                    fileType: ContestSubmissionFile::TYPE_THUMBNAIL,
                    isPrimary: true,
                    replaceExisting: true
                );
            
                $step = 3;
                break;
            
            case 3:
                $this->storeContestFiles(
                    request: $request,
                    contestSubmission: $contest_submission,
                    fileType: ContestSubmissionFile::TYPE_IMAGE,
                    replaceExisting: true
                );
            
                $step = 4;
            
                break;

            default:
                return back()->withErrors([
                    'step' => 'The submitted contest step is invalid.',
                ]);
        }

        $contest_submission->load([
            'event',
            'files',
            'primaryThumbnail',
        ]);

        $event = $contest_submission->event;

    
        return view(
            'contests.create',
            compact(
                'contest_submission',
                'event',
                'step'
            )
        );
    }
    private function storeContestFiles(
        Request $request,
        ContestSubmission $contestSubmission,
        string $fileType,
        bool $replaceExisting = true
    ): Collection {
        $validated = $request->validate([
            'contest_files' => [
                'required',
                'array',
                'min:1',
                'max:5',
            ],
            'contest_files.*' => [
                'required',
                'file',
                ...$this->multipleFileValidationRules($fileType),
            ],
        ], [
            'contest_files.required' => 'Please upload at least one submission page.',
            'contest_files.array' => 'The submission pages must be uploaded as files.',
            'contest_files.min' => 'Please upload at least one submission page.',
            'contest_files.max' => 'You may upload no more than 5 submission pages.',
            'contest_files.*.required' => 'Each submission page is required.',
            'contest_files.*.file' => 'Each submission page must be a valid file.',
            'contest_files.*.image' => 'Each submission page must be an image.',
            'contest_files.*.mimes' => 'Pages must be JPG, JPEG, PNG, or WEBP files.',
            'contest_files.*.max' => 'Each page may not be larger than 10 MB.',
        ]);
    
        if ($replaceExisting) {
            $existingFiles = $contestSubmission
                ->files()
                ->where('file_type', $fileType)
                ->get();
    
            foreach ($existingFiles as $existingFile) {
                $this->deleteStoredContestFile($existingFile);
            }
        }
    
        $storedFiles = collect();
    
        foreach ($validated['contest_files'] as $index => $uploadedFile) {
            $filePath = $uploadedFile->store(
                'contests/' .
                $contestSubmission->event_id .
                '/submissions/' .
                $contestSubmission->id .
                '/' .
                $this->directoryForFileType($fileType),
                's3-public'
            );
    
            $contestFile = $contestSubmission
                ->files()
                ->create([
                    'file_type' => $fileType,
                    'file_name' => $uploadedFile->getClientOriginalName(),
                    'file_path' => $filePath,
                    'mime_type' => $uploadedFile->getMimeType(),
                    'file_size' => $uploadedFile->getSize(),
                    'sort_order' => $index + 1,
                    'is_primary' => false,
                ]);
    
            $storedFiles->push($contestFile);
        }
    
        return $storedFiles;
    }
    private function storeContestFile(
        Request $request,
        ContestSubmission $contestSubmission,
        string $fileType,
        bool $isPrimary = false,
        bool $replaceExisting = false
    ): ContestSubmissionFile {
        $validated = $request->validate([
            'contest_file' => $this->fileValidationRules($fileType),
        ]);
    
        $uploadedFile = $validated['contest_file'];
    
        $currentFile = null;
    
        if ($replaceExisting) {
            $currentFile = $contestSubmission
                ->files()
                ->where('file_type', $fileType)
                ->when(
                    $isPrimary,
                    fn ($query) => $query->where('is_primary', true)
                )
                ->first();
        }
    
        $directory = 'contests/' .
            $contestSubmission->event_id .
            '/submissions/' .
            $contestSubmission->id .
            '/' .
            $this->directoryForFileType($fileType);
    
        $fileUrl = $uploadedFile->store(
            $directory,
            's3-public'
        );
    
        $newFile = $contestSubmission
            ->files()
            ->create([
                'file_type' => $fileType,
                'file_name' => $uploadedFile->getClientOriginalName(),
                'file_path' => $fileUrl,
                'mime_type' => $uploadedFile->getMimeType(),
                'file_size' => $uploadedFile->getSize(),
                'sort_order' => $this->nextSortOrder(
                    $contestSubmission,
                    $fileType
                ),
                'is_primary' => $isPrimary,
            ]);
    
        if ($isPrimary) {
            $contestSubmission
                ->files()
                ->where('file_type', $fileType)
                ->whereKeyNot($newFile->id)
                ->update([
                    'is_primary' => false,
                ]);
        }
    
        if ($currentFile) {
            $this->deleteStoredContestFile($currentFile);
        }
    
        return $newFile;
    }

    private function fileValidationRules(string $fileType): array
    {
        return match ($fileType) {
            ContestSubmissionFile::TYPE_THUMBNAIL,
            ContestSubmissionFile::TYPE_IMAGE => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            ContestSubmissionFile::TYPE_VIDEO => [
                'required',
                'file',
                'mimes:mp4,mov,webm',
                'max:102400',
            ],

            ContestSubmissionFile::TYPE_AUDIO => [
                'required',
                'file',
                'mimes:mp3,wav,m4a',
                'max:51200',
            ],

            ContestSubmissionFile::TYPE_PDF => [
                'required',
                'file',
                'mimes:pdf',
                'max:51200',
            ],

            ContestSubmissionFile::TYPE_DOCUMENT => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:51200',
            ],

            default => [
                'required',
                'file',
                'max:51200',
            ],
        };
    }
    

    private function directoryForFileType(string $fileType): string
    {
        return match ($fileType) {
            ContestSubmissionFile::TYPE_THUMBNAIL => 'thumbnails',
            ContestSubmissionFile::TYPE_IMAGE => 'pages',
            ContestSubmissionFile::TYPE_VIDEO => 'videos',
            ContestSubmissionFile::TYPE_AUDIO => 'audio',
            ContestSubmissionFile::TYPE_PDF => 'documents',
            ContestSubmissionFile::TYPE_DOCUMENT => 'documents',
            ContestSubmissionFile::TYPE_PORTFOLIO => 'portfolio',
            ContestSubmissionFile::TYPE_REFERENCE => 'references',
            default => 'files',
        };
    }

    private function nextSortOrder(
        ContestSubmission $contestSubmission,
        string $fileType
    ): int {
        return ((int) $contestSubmission
            ->files()
            ->where('file_type', $fileType)
            ->max('sort_order')) + 1;
    }

    private function multipleFileValidationRules(string $fileType): array
    {
        return match ($fileType) {
            ContestSubmissionFile::TYPE_IMAGE => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            ContestSubmissionFile::TYPE_PDF => [
                'mimes:pdf',
                'max:20480',
            ],

            ContestSubmissionFile::TYPE_VIDEO => [
                'mimetypes:video/mp4,video/quicktime,video/webm',
                'max:102400',
            ],

            ContestSubmissionFile::TYPE_AUDIO => [
                'mimetypes:audio/mpeg,audio/wav,audio/x-wav,audio/mp4',
                'max:51200',
            ],

            ContestSubmissionFile::TYPE_DOCUMENT => [
                'mimes:pdf,doc,docx',
                'max:20480',
            ],

            default => [
                'max:10240',
            ],
        };
    }

    public function submit(
        Request $request,
        ContestSubmission $contest_submission
    ) {
        abort_if(
            $contest_submission->user_id !== auth()->id() &&
            auth()->user()->current_team_id != 2,
            403
        );
    
        $contest_submission->submission_status = ContestSubmission::STATUS_SUBMITTED;
        $contest_submission->submitted_at = now();
        $contest_submission->save();
        $contest_submission_event_id = $contest_submission->event->id;
    
        $submissions = auth()->user()->current_team_id == 2
            ? ContestSubmission::whereNull('deleted_at')->get()
            : ContestSubmission::where('user_id', auth()->id())->get();
    
        return view('contests.index', compact('submissions','contest_submission_event_id'));
    }

    private function deleteStoredContestFile(
        ContestSubmissionFile $contestFile
    ): void {
        if (
            $contestFile->file_path &&
            Storage::disk('s3-public')->exists($contestFile->file_path)
        ) {
            Storage::disk('s3-public')->delete(
                $contestFile->file_path
            );
        }
    
        $contestFile->delete();
    }

}
