<?php

namespace App\Http\Controllers;

use App\Http\Resources\loseResultResource;
use App\Http\Resources\WinResultResource;
use App\Http\Services\LuckyService;
use App\Http\Requests\PlayRequest;
use App\Http\Requests\HistoryRequest;

class LuckyController extends Controller
{
    /**
     * @param LuckyService $luckyService
     */
    public function __construct(
        private readonly LuckyService $luckyService
    ) {}

    /**
     * Handles the play action.
     *
     * This method attempts to play a game using the provided request data, checks if the player has won,
     * and redirects back with the appropriate result message (win, lose, or error).
     *
     * @param PlayRequest $request The HTTP request containing necessary input.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function play(PlayRequest $request)
    {
        try {
            $result = $this->luckyService->play($request->get('link_id'));
            if ($result['isWin']) {
                return redirect()->back()->with(
                    'winResult',
                    (new WinResultResource($result))->resolve()
                );

            }
            return redirect()->back()->with(
                'loseResult',
                (new loseResultResource($result))->resolve()
            );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Handles the retrieval of the last history records based on the provided request.
     *
     * @param HistoryRequest $request The HTTP request containing the necessary parameters.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the results.
     */
    public function lastHistory(HistoryRequest $request)
    {
        $results = $this->luckyService->getLastResults($request->get('link_id'));
        return response()->json($results);
    }
}
