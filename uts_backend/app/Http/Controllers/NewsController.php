<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    // Fungsi untuk mengambil semua berita
    public function index()
    {
        // Mengambil semua data berita dari database
        $news = News::all();
        
        // Mengembalikan response JSON dengan data berita
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }

    // Fungsi untuk menambahkan berita baru
    public function store(Request $request)
    {
        // Validasi data input dari request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255', // Validasi title
            'author' => 'required|string|max:100', // Validasi author
            'description' => 'required|string', // Validasi description
            'content' => 'required', // Validasi content
            'url' => 'required|url', // Validasi url
            'url_image' => 'nullable|url', // Validasi url_image (nullable)
            'published_at' => 'nullable|date', // Validasi published_at (nullable)
            'category' => 'required|string' // Validasi category
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors() // Menampilkan error validasi
            ], 400);
        }

        // Membuat data berita baru menggunakan data dari request
        $news = News::create($request->all());

        // Mengembalikan response JSON dengan data berita yang baru dibuat
        return response()->json([
            'success' => true,
            'data' => $news
        ], 201);
    }

    // Fungsi untuk menampilkan detail berita berdasarkan ID
    public function show($id)
    {
        // Mencari berita berdasarkan ID
        $news = News::find($id);

        // Jika berita tidak ditemukan, kembalikan error
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        // Mengembalikan response JSON dengan data berita yang ditemukan
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }

    // Fungsi untuk mengupdate berita berdasarkan ID
    public function update(Request $request, $id)
    {
        // Mencari berita berdasarkan ID
        $news = News::find($id);

        // Jika berita tidak ditemukan, kembalikan error
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        // Validasi data input dari request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:100',
            'description' => 'required|string',
            'content' => 'required',
            'url' => 'required|url',
            'url_image' => 'nullable|url',
            'published_at' => 'nullable|date',
            'category' => 'required|string'
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 400);
        }

        // Update data berita dengan data yang baru dari request
        $news->update($request->all());

        // Mengembalikan response JSON dengan data berita yang telah diperbarui
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }

    // Fungsi untuk menghapus berita berdasarkan ID
    public function destroy($id)
    {
        // Mencari berita berdasarkan ID
        $news = News::find($id);

        // Jika berita tidak ditemukan, kembalikan error
        if (!$news) {
            return response()->json([
                'success' => false,
                'message' => 'News not found'
            ], 404);
        }

        // Menghapus data berita dari database
        $news->delete();

        // Mengembalikan response JSON yang menyatakan berita berhasil dihapus
        return response()->json([
            'success' => true,
            'message' => 'News deleted successfully'
        ], 200);
    }
    
    // Fungsi untuk mencari berita berdasarkan judul
    public function search($title)
    {
        // Mencari berita yang judulnya mengandung kata kunci
        $news = News::where('title', 'LIKE', "%{$title}%")->get();

        // Mengembalikan response JSON dengan data berita yang ditemukan
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }

    // Fungsi untuk mengambil berita berdasarkan kategori
    public function getByCategory($category)
    {
        // Mencari berita berdasarkan kategori
        $news = News::where('category', $category)->get();

        // Mengembalikan response JSON dengan data berita yang ditemukan
        return response()->json([
            'success' => true,
            'data' => $news
        ], 200);
    }
}
