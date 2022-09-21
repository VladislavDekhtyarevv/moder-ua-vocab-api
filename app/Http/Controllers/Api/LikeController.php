<?php

namespace App\Http\Controllers\Api;

use App\Models\Word;
use App\Services\LikeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LikeController extends Controller
{
    public function __construct(
        LikeService $likeService
    )
    {
        $this->LikeService = $likeService;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleLike(Request $request)
    {
        $res = $this->LikeService->toggle($request->id, 'like');
        if($res) {
            return response(['status' => 'success', 'message' => 'Voted', 'payload' => $res], 200);
        }
        return response(['status' => 'error', 'message' => 'Unlike'], 406);
    }

    public function toggleDislike(Request $request)
    {
        $res = $this->LikeService->toggle($request->id, 'dislike');
        if($res) {
            return response(['status' => 'success', 'message' => 'Voted', 'payload' => $res], 200);
        }
        return response(['status' => 'error', 'message' => 'Unlike'], 406);
    }

}
