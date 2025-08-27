<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $books = Auth::user()
            ->books()
            ->when($request->filled('search'), fn ($q) =>
                $q->where('title', 'like', '%'.$request->input('search').'%')
            )
            ->paginate(15);

        return view('books.index', [
            'books' => $books,
            'search' => $search ?? null
        ]);
    }

    public function create(Request $request)
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'description' => $request->description ?? null,
            'stock' => $request->stock,
            'user_id' => Auth::id(),
        ]);

        Session::flash('status', __('Book created successfully.'));

        return redirect()->route('books.index');
    }

    public function edit(Request $request, Book $book)
    {
        //Gate::authorize('update', $book);

        if (Auth::user()->cannot('update', $book)) {
            abort(403);
        }

        return view('books.create', [
            'book' => $book
        ]);
    }

    public function update(Request $request, Book $book)
    {
        if (Auth::user()->cannot('update', $book)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
        ]);

        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'price' => $request->price,
            'description' => $request->description ?? null,
            'stock' => $request->stock,
        ]);

        Session::flash('status', __('Book updated successfully.'));

        return redirect()->route('books.index');
    }

    public function destroy(Request $request, Book $book)
    {
        if (Auth::user()->cannot('delete', $book)) {
            abort(403);
        }

        $book->delete();

        Session::flash('status', __('Book deleted successfully.'));

        return redirect()->route('books.index');
    }
}
