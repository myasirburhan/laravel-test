<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function store(Request $req): JsonResponse
    {
        try {
            $param = [
                'title' => $req->title,
                'content' => $req->content,
                'image' => $req->image,
            ];

            Post::create($param);
            return response()->json([
                'success' => true,
                'message' => 'Data Inserted',
                'data' => [],
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function findAll(Request $req): JsonResponse
    {
        try {
            $data = Post::take(10)->skip(0)->get();
            return response()->json([
                'success' => true,
                'message' => 'Data Loaded',
                'data' => $data,
            ], Response::HTTP_OK);
        } catch (Exception $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $req, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            Post::find($id)->update([
                'title' => $req->title,
                'content' => $req->content,
                'image' => $req->image,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Updated',
                'data' => [],
            ], Response::HTTP_OK);
        } catch (Exception $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $req, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            Post::find($id)->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Deleted',
                'data' => [],
            ], Response::HTTP_OK);
        } catch (Exception $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
                'data' => [],
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
