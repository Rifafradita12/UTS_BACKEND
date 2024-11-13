<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    // Method index
    public function index()
    {
        // Retrieve all news data
        $news = News::all();

        // Check if the data is empty
        if ($news->isEmpty()) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Response if data is found
        $response = [
            'data' => $news,
            'message' => 'Berhasil menampilkan semua data berita'
        ];

        return response()->json($response, 200);
    }

    // Method to add new data
    public function store(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'content' => 'required|string',
            'url' => 'required|url|unique:news',
            'url_image' => 'required|url',
            'published_at' => 'required|date',
            'category' => 'required|string'
        ]);

        // Check if validation has errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak lengkap atau tidak valid',
                'errors' => $validator->errors()
            ], 400);
        }

        // Create news data
        $news = News::create($request->all());

        $response = [
            'message' => 'Berhasil menambahkan berita',
            'data' => $news
        ];

        return response()->json($response, 201);
    }

    // Method to update data
    public function update(Request $request, $id)
    {
        // Find news by ID
        $news = News::find($id);

        // If news is not found, return 404 response
        if (!$news) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string',
            'author' => 'sometimes|required|string',
            'description' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'url' => 'sometimes|required|url|unique:news,url,' . $id,
            'url_image' => 'sometimes|required|url',
            'published_at' => 'sometimes|required|date',
            'category' => 'sometimes|required|string'
        ]);

        // Check if validation has errors
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data tidak lengkap atau tidak valid',
                'errors' => $validator->errors()
            ], 400);
        }

        // Update news data
        $news->update($request->only([
            'title', 'author', 'description', 'content', 'url', 'url_image', 'published_at', 'category'
        ]));

        $response = [
            'message' => 'Berhasil memperbarui berita',
            'data' => $news
        ];

        return response()->json($response, 200);
    }

    // Method to delete data
    public function destroy($id)
    {
        // Find news by ID
        $news = News::find($id);

        // If news is not found, return 404 response
        if (!$news) {
            return response()->json(['message' => 'Berita tidak ditemukan'], 404);
        }

        // Delete news data
        $news->delete();

        $response = [
            'message' => 'Berhasil menghapus berita',
            'data' => $news
        ];

        return response()->json($response, 200);
    }
}
