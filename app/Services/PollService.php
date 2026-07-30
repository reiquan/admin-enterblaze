<?php

namespace App\Services;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
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
        array $options = []
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
}