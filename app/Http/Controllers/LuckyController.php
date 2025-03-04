<?php

namespace App\Http\Controllers;

use App\Http\Services\LuckyService;
use Illuminate\Http\Request;

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
     * @param Request $request The HTTP request containing necessary input.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function play(Request $request)
    {
        try {
            $result = $this->luckyService->play($request->get('link_id'));
            if ($result['isWin']) {
                return redirect()->back()->with(
                    'winResult',
                    "You win! Number: {$result['number']}. You got {$result['prize']} $."
                );
            }
            return redirect()->back()->with('loseResult', "You lose!");
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Handles the retrieval of the last history records based on the provided request.
     *
     * @param Request $request The HTTP request containing the necessary parameters.
     * @return \Illuminate\Http\JsonResponse A JSON response containing the results.
     */
    public function lastHistory(Request $request)
    {
        $results = $this->luckyService->getLastResults($request->get('link_id'));
        return response()->json($results);
    }
}
