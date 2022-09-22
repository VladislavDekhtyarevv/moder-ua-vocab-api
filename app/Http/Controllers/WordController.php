<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\WordRequest;
use App\Http\Resources\WordResource;
use App\Models\Word;
use App\Services\WordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WordController extends Controller
{

    public function __construct(
        WordService $wordService
    )
    {
        $this->WordService = $wordService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Word::withCount(['upvoters', 'downvoters'])->filter($request)->paginate(12);
        return WordResource::collection($data);
    }
    public function personalIndex(Request $request)
    {
        $user = Auth::user();
        $data = $user->words()->withCount(['upvoters', 'downvoters'])->filter($request)->paginate(12);
        return WordResource::collection($data);
    }
    public function likedIndex(Request $request)
    {
        $userId = Auth::id();
        $data = Word::withCount(['upvoters', 'downvoters'])->whereHas('voters', function($q) use ($userId) {
            $q->where('user_id', $userId)
              ->where('votes', '>', 0);
        })->filter($request)->paginate(12);
        return WordResource::collection($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WordRequest $request)
    {
        $user = Auth::user();
        $response = $this->WordService->create($request, $user);

        if($response) {
            return response(['status' => 'success', 'message' => 'Слово успішно створено'], 200);
        }
        return response(['status' => 'error', 'message' => 'Слово не створено'], 406);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function show(Word $word)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function edit(Word $word)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Word $word)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Word  $word
     * @return \Illuminate\Http\Response
     */
    public function destroy(Word $word)
    {
        $userId = Auth::id();
        if($word->delete() && $word->user_id = $userId) {
            return response(['status' => 'success', 'message' => 'Слово успішно видалено'], 200);
        }
        return response(['status' => 'error', 'message' => 'Слово не видалено'], 406);
    }
}
