<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Poll;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class PollController extends Controller
{


public function index(Request $request): View
{
    $pollQuery = Poll::query()
        ->withCount([
            'options',
            'votes',
        ])
        ->with('pollable');

    $pollQuery->when(
        $request->filled('search'),
        function (Builder $query) use ($request) {
            $query->where(
                'question',
                'like',
                '%' . $request->string('search')->trim() . '%'
            );
        }
    );

    $pollQuery->when(
        $request->filled('selection_type'),
        function (Builder $query) use ($request) {
            $query->where(
                'selection_type',
                $request->string('selection_type')
            );
        }
    );

    $pollQuery->when(
        $request->filled('status'),
        function (Builder $query) use ($request) {
            $status = $request->string('status')->toString();

            match ($status) {
                'active' => $query
                    ->where('is_published', true)
                    ->where(function (Builder $query) {
                        $query->whereNull('starts_at')
                            ->orWhere('starts_at', '<=', now());
                    })
                    ->where(function (Builder $query) {
                        $query->whereNull('ends_at')
                            ->orWhere('ends_at', '>=', now());
                    }),

                'scheduled' => $query
                    ->where('is_published', true)
                    ->where('starts_at', '>', now()),

                'ended' => $query
                    ->whereNotNull('ends_at')
                    ->where('ends_at', '<', now()),

                'draft' => $query
                    ->where('is_published', false),

                default => $query,
            };
        }
    );

    $polls = $pollQuery
        ->latest()
        ->paginate(12);

    $publishedPollCount = Poll::where(
        'is_published',
        true
    )->count();

    $activePollCount = Poll::available()->count();

    $totalVoteCount = \App\Models\PollVote::count();

    return view('polls.index', compact(
        'polls',
        'publishedPollCount',
        'activePollCount',
        'totalVoteCount'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          //
  

          return view('polls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
{
    $validated = $request->validate(
        [
            'question' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'selection_type' => [
                'required',
                Rule::in([
                    'single',
                    'multiple',
                ]),
            ],

            'maximum_selections' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],

            'allow_guests' => [
                'required',
                'boolean',
            ],

            'show_results_before_voting' => [
                'required',
                'boolean',
            ],

            'show_results_after_voting' => [
                'required',
                'boolean',
            ],

            'is_published' => [
                'required',
                'boolean',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'ends_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],

            'options' => [
                'required',
                'array',
                'min:2',
                'max:20',
            ],

            'options.*' => [
                'required',
                'array',
            ],

            'options.*.name' => [
                'required',
                'string',
                'max:255',
            ],

            'options.*.description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'options.*.image' => [
                'nullable',
                'url:http,https',
                'max:2048',
            ],
        ],
        [
            'question.required' => 'Please enter a poll question.',

            'selection_type.required' => 'Please select a voting type.',
            'selection_type.in' => 'The selected voting type is invalid.',

            'maximum_selections.required' => 'Please enter the maximum number of selections.',
            'maximum_selections.min' => 'Voters must be allowed to select at least one option.',
            'maximum_selections.max' => 'Voters cannot select more than 20 options.',

            'options.required' => 'Please add poll options.',
            'options.min' => 'A poll must contain at least two options.',
            'options.max' => 'A poll cannot contain more than 20 options.',

            'options.*.name.required' => 'Every poll option must have a name.',
            'options.*.name.max' => 'A poll option name cannot exceed 255 characters.',

            'options.*.description.max' => 'An option description cannot exceed 1,000 characters.',

            'options.*.image.url' => 'Each option image must be a valid HTTP or HTTPS URL.',
            'options.*.image.max' => 'An option image URL cannot exceed 2,048 characters.',

            'ends_at.after' => 'The poll end date must be after its start date.',
        ]
    );

    /*
     * Remove accidental whitespace before saving.
     */
    $options = collect($validated['options'])
        ->map(function (array $option): array {
            return [
                'name' => trim($option['name']),
                'description' => filled($option['description'] ?? null)
                    ? trim($option['description'])
                    : null,
                'image' => filled($option['image'] ?? null)
                    ? trim($option['image'])
                    : null,
            ];
        })
        ->values();

    /*
     * Prevent empty option names made entirely from spaces.
     */
    if ($options->contains(
        fn (array $option): bool => $option['name'] === ''
    )) {
        throw ValidationException::withMessages([
            'options' => 'Every poll option must have a name.',
        ]);
    }

    /*
     * Prevent duplicate option names.
     * Comparison is case-insensitive, so "Na'Qir" and "na'qir"
     * are treated as duplicates.
     */
    $normalizedNames = $options
        ->pluck('name')
        ->map(
            fn (string $name): string => mb_strtolower($name)
        );

    if ($normalizedNames->duplicates()->isNotEmpty()) {
        throw ValidationException::withMessages([
            'options' => 'Each poll option must have a unique name.',
        ]);
    }

    $maximumSelections = $validated['selection_type'] === 'single'
        ? 1
        : (int) $validated['maximum_selections'];

    /*
     * A voter cannot select more options than the poll contains.
     */
    if ($maximumSelections > $options->count()) {
        throw ValidationException::withMessages([
            'maximum_selections' => sprintf(
                'Maximum selections cannot exceed the number of poll options (%d).',
                $options->count()
            ),
        ]);
    }

    $poll = DB::transaction(function () use (
        $validated,
        $options,
        $maximumSelections
    ): Poll {
        $poll = Poll::create([
            'question' => trim($validated['question']),

            'description' => filled($validated['description'] ?? null)
                ? trim($validated['description'])
                : null,

            'selection_type' => $validated['selection_type'],

            'maximum_selections' => $maximumSelections,

            'allow_guests' => (bool) $validated['allow_guests'],

            'show_results_before_voting' =>
                (bool) $validated['show_results_before_voting'],

            'show_results_after_voting' =>
                (bool) $validated['show_results_after_voting'],

            'is_published' => (bool) $validated['is_published'],

            'starts_at' => $validated['starts_at'] ?? null,

            'ends_at' => $validated['ends_at'] ?? null,
        ]);

        $poll->options()->createMany(
            $options
                ->map(function (array $option, int $index): array {
                    return [
                        'name' => $option['name'],
                        'description' => $option['description'],
                        'image' => $option['image'],
                        'sort_order' => $index,
                    ];
                })
                ->all()
        );

        return $poll;
    });

    return redirect()
        ->route('polls.show', $poll)
        ->with(
            'success',
            $poll->is_published
                ? 'Poll created and published successfully.'
                : 'Poll saved as a draft successfully.'
        );
}

    public function show(Request $request, $poll_id): View|RedirectResponse
    {
        // dd($poll_id);
        $poll = Poll::find($poll_id);

        if (!$poll) {
            return redirect()
                ->route('polls.index')
                ->with('error', 'The requested poll could not be found.');
        }

        try {
            $poll->load([
                'options' => function ($query) {
                    $query
                        ->withCount('votes')
                        ->orderBy('sort_order');
                },
            ]);

            $poll->loadCount('votes');
        } catch (Throwable $exception) {
            Log::error('Poll vote relationships could not be loaded.', [
                'poll_id' => $poll->id,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            // Graceful fallback: load options without vote counts.
            $poll->load([
                'options' => function ($query) {
                    $query->orderBy('sort_order');
                },
            ]);

            // Supply the attributes expected by the Blade file.
            $poll->setAttribute('votes_count', 0);

            $poll->options->each(function ($option) {
                $option->setAttribute('votes_count', 0);
            });
        }

        return view('polls.show', compact('poll'));
    }   
    public function edit(Poll $poll): View|RedirectResponse
    {
        try {
            $poll->load([
                'options' => function ($query) {
                    $query->orderBy('sort_order');
                },
            ]);

            return view('polls.edit', compact('poll'));
        } catch (Throwable $exception) {
            Log::error('Poll could not be loaded for editing.', [
                'poll_id' => $poll->id ?? null,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            return redirect()
                ->route('polls.index')
                ->with('error', 'The poll could not be loaded for editing.');
        }
    }

    public function update(Request $request, Poll $poll): RedirectResponse
    {
        $validated = $request->validate([
            'question' => [
                'required',
                'string',
                'max:255',
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'selection_type' => [
                'required',
                Rule::in(['single', 'multiple']),
            ],
            'maximum_selections' => [
                'required',
                'integer',
                'min:1',
                'max:20',
            ],
            'allow_guests' => [
                'nullable',
                'boolean',
            ],
            'show_results_before_voting' => [
                'nullable',
                'boolean',
            ],
            'show_results_after_voting' => [
                'nullable',
                'boolean',
            ],
            'is_published' => [
                'nullable',
                'boolean',
            ],
            'starts_at' => [
                'nullable',
                'date',
            ],
            'ends_at' => [
                'nullable',
                'date',
                'after:starts_at',
            ],
            'options' => [
                'required',
                'array',
                'min:2',
                'max:20',
            ],
            'options.*.id' => [
                'nullable',
                'integer',
            ],
            'options.*.name' => [
                'required',
                'string',
                'max:255',
            ],
            'options.*.description' => [
                'nullable',
                'string',
            ],
            'options.*.image' => [
                'nullable',
                'string',
                'max:2048',
            ],
        ]);
    
        $options = collect($validated['options'])
            ->map(function (array $option) {
                return [
                    'id' => !empty($option['id'])
                        ? (int) $option['id']
                        : null,
                    'name' => trim($option['name']),
                    'description' => isset($option['description'])
                        ? trim($option['description'])
                        : null,
                    'image' => isset($option['image'])
                        ? trim($option['image'])
                        : null,
                ];
            })
            ->values();
    
        if ($options->contains(fn (array $option) => $option['name'] === '')) {
            throw ValidationException::withMessages([
                'options' => 'Every poll option must have a name.',
            ]);
        }
    
        $normalizedNames = $options
            ->pluck('name')
            ->map(fn (string $name) => mb_strtolower(trim($name)));
    
        if ($normalizedNames->duplicates()->isNotEmpty()) {
            throw ValidationException::withMessages([
                'options' => 'Poll option names must be unique.',
            ]);
        }
    
        $maximumSelections = $validated['selection_type'] === 'single'
            ? 1
            : (int) $validated['maximum_selections'];
    
        if ($maximumSelections > $options->count()) {
            throw ValidationException::withMessages([
                'maximum_selections' =>
                    'Maximum selections cannot exceed the number of poll options.',
            ]);
        }
    
        try {
            DB::transaction(function () use (
                $poll,
                $validated,
                $options,
                $maximumSelections
            ) {
                $poll->update([
                    'question' => trim($validated['question']),
                    'description' => !empty($validated['description'])
                        ? trim($validated['description'])
                        : null,
                    'selection_type' => $validated['selection_type'],
                    'maximum_selections' => $maximumSelections,
                    'allow_guests' => request()->boolean('allow_guests'),
                    'show_results_before_voting' =>
                        request()->boolean('show_results_before_voting'),
                    'show_results_after_voting' =>
                        request()->boolean('show_results_after_voting'),
                    'is_published' => request()->boolean('is_published'),
                    'starts_at' => $validated['starts_at'] ?? null,
                    'ends_at' => $validated['ends_at'] ?? null,
                ]);
    
                $submittedOptionIds = $options
                    ->pluck('id')
                    ->filter()
                    ->values();
    
                /*
                 * Only delete options that belong to this poll and were removed
                 * from the edit form.
                 */
                $removedOptions = $poll->options()
                    ->when(
                        $submittedOptionIds->isNotEmpty(),
                        fn ($query) => $query->whereNotIn(
                            'id',
                            $submittedOptionIds
                        )
                    )
                    ->when(
                        $submittedOptionIds->isEmpty(),
                        fn ($query) => $query
                    )
                    ->get();
    
                foreach ($removedOptions as $removedOption) {
                    /*
                     * Keep this block if poll_option votes do not use
                     * cascadeOnDelete().
                     */
                    if (method_exists($removedOption, 'votes')) {
                        $removedOption->votes()->delete();
                    }
    
                    $removedOption->delete();
                }
    
                foreach ($options as $index => $optionData) {
                    $attributes = [
                        'name' => $optionData['name'],
                        'description' => $optionData['description'] ?: null,
                        'image' => $optionData['image'] ?: null,
                        'sort_order' => $index,
                    ];
    
                    if ($optionData['id']) {
                        /*
                         * Find through the relationship so a user cannot submit
                         * an option ID belonging to another poll.
                         */
                        $option = $poll->options()
                            ->whereKey($optionData['id'])
                            ->first();
    
                        if ($option) {
                            $option->update($attributes);
    
                            continue;
                        }
                    }
    
                    $poll->options()->create($attributes);
                }
            });
    
            return redirect()
                ->route('polls.show', $poll)
                ->with('success', 'Poll updated successfully.');
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            Log::error('Poll update failed.', [
                'poll_id' => $poll->id,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
    
            return back()
                ->withInput()
                ->with(
                    'error',
                    'The poll could not be updated. Please try again.'
                );
        }
    }

    public function destroy(Poll $poll): RedirectResponse
    {
        // dd($poll->toArray());
        try {
            DB::transaction(function () use ($poll) {
                /*
                 * Delete votes first if your database does not use
                 * cascadeOnDelete() for poll_votes.
                 */
                if (method_exists($poll, 'votes')) {
                    $poll->votes()->delete();
                }
    
                /*
                 * Delete votes belonging to each option, then delete options.
                 * This protects against foreign-key constraint errors.
                 */
                if (method_exists($poll, 'options')) {
                    $poll->loadMissing('options');
    
                    foreach ($poll->options as $option) {
                        if (method_exists($option, 'votes')) {
                            $option->votes()->delete();
                        }
                    }
    
                    $poll->options()->delete();
                }
    
                $poll->delete();
            });
    
            return redirect()
                ->route('polls.index')
                ->with('success', 'Poll deleted successfully.');
        } catch (Throwable $exception) {
            Log::error('Poll could not be deleted.', [
                'poll_id' => $poll->id ?? null,
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);
    
            return redirect()
                ->route('polls.show', $poll)
                ->with('error', 'The poll could not be deleted. Please try again.');
        }
    }
}
