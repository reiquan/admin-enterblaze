<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventLivestream;
use App\Services\TwitchService;
use Illuminate\Http\JsonResponse;
use Throwable;

class EventLivestreamsController extends Controller
{
    public function current(
        TwitchService $twitch
    ): JsonResponse {
        $event = EventLivestream::query()
            ->join('events', 'events.id', '=', 'event_livestreams.event_id')
            ->where('events.is_active', true)
            ->where('events.event_is_livestream', true)
            ->where('event_livestreams.event_livestream_platform', 'twitch')
            ->where(function ($query) {
                $query->whereNull('events.event_end_date')
                    ->orWhere('events.event_end_date', '>=', now());
            })
            ->where(
                'events.event_start_date',
                '<=',
                now()->addDays(7)
            )
            ->select([
                'events.*',
                'event_livestreams.*',
            ])
            ->orderBy('events.event_start_date')
            ->first();

    
    if (!$event) {
        return response()->json([
            'status' => 'success',
            'data' => null,
        ]);
    }

        $channelName = config(
            'services.twitch.channel_name'
        );

        try {
            $twitchUser = $twitch->getUserByLogin(
                $channelName
            );

            $liveStream = $twitchUser
                ? $twitch->getLiveStream($twitchUser['id'])
                : null;
        } catch (Throwable $exception) {
            report($exception);

            $liveStream = null;
        }

        $thumbnail = $liveStream['thumbnail_url']
            ?? $event->event_image;

        if (!empty($liveStream['thumbnail_url'])) {
            $thumbnail = str_replace(
                ['{width}', '{height}'],
                ['1280', '720'],
                $liveStream['thumbnail_url']
            );
        }

        return response()->json([
            'status' => 'success',

            'data' => [
                'id' => $event->id,
                'title' => $liveStream['title']
                    ?? $event->event_twitch_title
                    ?? $event->event_title,

                'description' =>
                    $event->event_description,

                'image' => $thumbnail,

                'starts_at' => $event
                    ->event_starts_at
                    ?->utc()
                    ->toIso8601String(),

                'ends_at' => $event
                    ->event_ends_at
                    ?->utc()
                    ->toIso8601String(),

                'is_live' => $liveStream !== null,

                'viewer_count' =>
                    $liveStream['viewer_count'] ?? 0,

                'channel' => $channelName,

                'event_url' => route(
                    'events.show',
                    $event
                ),
            ],
        ]);
    }
}