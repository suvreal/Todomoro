<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Inspiring;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * @var string
     */
    protected $rootView = 'app';

    /**
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        [$message, $author] = $this->prepareValues();
        $ziggy = new Ziggy();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'quote' => [
                'message' => trim($message),
                'author' => trim($author),
            ],
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => [
                ...$ziggy->toArray(),
                'location' => $request->url(),
            ],
            'sidebarOpen' => $request->hasCookie('sidebar_state') === false
                || $request->cookie('sidebar_state') === 'true',
        ];
    }

    /**
     * @return array<int, string>
     */
    private function prepareValues(): array
    {
        $quote = Inspiring::quotes()->random();
        if (is_string($quote) === false) {
            $quote = '';
        }

        [$message, $author] = str($quote)->explode('-');
        if (is_string($message) === false) {
            $message = '';
        }
        if (is_string($author) === false) {
            $author = '';
        }

        return [
            $message,
            $author,
        ];
    }
}
