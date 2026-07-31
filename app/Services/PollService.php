<?php

namespace App\Services;

use App\Models\Poll;
use App\Models\PollOption;
use App\Models\PollVote;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Str;
use Throwable;

class PollService
{
    /**
     * Create a default poll for an Issue, Webisode, Event,
     * Book, or any other model using the polls() relationship.
     */
    public function createDefaultPoll(
        Model $pollable,
        array $attributes = [],
        array $options = [],
    ): Poll {
        if (!$pollable->exists) {
            throw new InvalidArgumentException(
                'The pollable model must be saved before creating a poll.'
            );
        }

        if (!method_exists($pollable, 'polls')) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s must define a polls() relationship.',
                    $pollable::class
                )
            );
        }

        $existingPoll = $pollable->polls()
            ->where('is_default', true)
            ->first();

        if ($existingPoll) {
            return $existingPoll->load('options');
        }

        $defaultOptions = [
            [
                'name' => 'This is Fire!!',
                'description' => null,
                'image' => null,
            ],
            [
                'name' => 'Its OK',
                'description' => null,
                'image' => null,
            ],
            [
                'name' => 'Its terrible!',
                'description' => null,
                'image' => null,
            ],
        ];

        $pollOptions = !empty($options)
            ? $options
            : $defaultOptions;

        if (count($pollOptions) < 2) {
            throw new InvalidArgumentException(
                'A poll must have at least two options.'
            );
        }

        try {
            return DB::transaction(function () use (
                $pollable,
                $attributes,
                $pollOptions
            ) {
                $poll = $pollable->polls()->create([
                    'question' => $attributes['question']
                        ?? $this->getDefaultQuestion($pollable),

                    'description' => $attributes['description']
                        ?? $this->getDefaultDescription($pollable),

                    'selection_type' => $attributes['selection_type']
                        ?? 'single',

                    'maximum_selections' =>
                        ($attributes['selection_type'] ?? 'single') === 'single'
                            ? 1
                            : ($attributes['maximum_selections'] ?? 1),

                    'allow_guests' => $attributes['allow_guests']
                        ?? false,

                    'show_results_before_voting' =>
                        $attributes['show_results_before_voting']
                            ?? false,

                    'show_results_after_voting' =>
                        $attributes['show_results_after_voting']
                            ?? true,

                    'is_published' => $attributes['is_published']
                        ?? false,

                    'starts_at' => $attributes['starts_at']
                        ?? null,

                    'ends_at' => $attributes['ends_at']
                        ?? null,
                    'is_default' => $attributes['is_default'] ?? true,
                ]);

                foreach ($pollOptions as $index => $option) {
                    $poll->options()->create([
                        'name' => trim($option['name']),
                        'description' => filled(
                            $option['description'] ?? null
                        )
                            ? trim($option['description'])
                            : null,
                        'image' => filled($option['image'] ?? null)
                            ? trim($option['image'])
                            : null,
                        'sort_order' => $index,
                    ]);
                }

                return $poll->load('options');
            });
        } catch (Throwable $exception) {
            Log::error('Default poll creation failed.', [
                'pollable_type' => $pollable::class,
                'pollable_id' => $pollable->getKey(),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]);

            throw $exception;
        }
    }

    /**
     * Create the default question based on the attached model.
     */
    private function getDefaultQuestion(Model $pollable): string
    {
        $title = $this->getPollableTitle($pollable);

        return match (class_basename($pollable)) {
            'Issue' => "What did you think of {$title}?",
            'Webisode' => "What did you think of {$title}?",
            'Event' => "Are you interested in {$title}?",
            'Book' => "What did you think of {$title}?",
            default => "What did you think of {$title}?",
        };
    }

    /**
     * Create a default poll description.
     */
    private function getDefaultDescription(Model $pollable): string
    {
        return match (class_basename($pollable)) {
            'Issue' => 'Vote and let us know what you thought about this issue.',
            'Webisode' => 'Vote and let us know what you thought about this webisode.',
            'Event' => 'Let us know whether you are interested in this event.',
            'Book' => 'Vote and share your opinion about this book.',
            default => 'Cast your vote below.',
        };
    }

    /**
     * Attempt to find the model's display title.
     */
    private function getPollableTitle(Model $pollable): string
    {
        return $pollable->title
            ?? $pollable->name
            ?? $pollable->issue_title
            ?? $pollable->webisode_title
            ?? class_basename($pollable);
    }

    public function storeVote(Request $request)
    {
        $validated = $request->validate([
            'poll_id' => [
                'required',
                'integer',
                'exists:polls,id',
            ],
            'option_id' => [
                'required',
                'integer',
                'exists:poll_options,id',
            ],
            'voter_identifier' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $poll = Poll::query()
            ->findOrFail($validated['poll_id']);

        $option = PollOption::query()
            ->where('id', $validated['option_id'])
            ->where('poll_id', $poll->id)
            ->first();

        if (!$option) {
            return response()->json([
                'message' => 'The selected option does not belong to this poll.',
            ], 422);
        }

        /*
         * For authenticated API users, use the user ID.
         * For guests, receive a persistent identifier from the front site.
         * IP is included as a fallback, but should not be the only identifier.
         */
        $userId = $request->user()?->id;

        $voterIdentifier = $userId
            ? 'user:' . $userId
            : $validated['voter_identifier'] ?? null;

        if (!$voterIdentifier) {
            $voterIdentifier = hash(
                'sha256',
                implode('|', [
                    $request->ip(),
                    $request->userAgent() ?? '',
                    $poll->id,
                ])
            );
        }

        try {
            $vote = DB::transaction(function () use (
                $request,
                $poll,
                $option,
                $userId,
                $voterIdentifier
            ) {
                return PollVote::create([
                    'poll_id' => $poll->id,
                    'poll_option_id' => $option->id,
                    'user_id' => $userId,
                    'voter_identifier' => $voterIdentifier,
                    'ip_address' => $request->ip(),
                    'user_agent' => Str::limit(
                        $request->userAgent() ?? '',
                        1000
                    ),
                ]);
            });
        } catch (QueryException $exception) {
            if (
                in_array(
                    $exception->getCode(),
                    ['23000', '23505'],
                    true
                )
            ) {
                return response()->json([
                    'message' => 'You have already voted in this poll.',
                ], 409);
            }

            throw $exception;
        }

        return response()->json([
            'message' => 'Your vote was recorded successfully.',
            'data' => [
                'vote_id' => $vote->id,
                'poll_id' => $vote->poll_id,
                'option_id' => $vote->poll_option_id,
            ],
        ], 201);
    }
}