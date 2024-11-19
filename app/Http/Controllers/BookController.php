<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public $books = [
        ['id' => 1, 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee'],
        ['id' => 2, 'title' => '1984', 'author' => 'George Orwell'],
        ['id' => 3, 'title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald'],
    ];

    public function __construct()
    {
        if (!session()->has('books')) {
            session(['books' => $this->books]);
        }
    }

    public function index()
    {
        return view('books.index', ['books' => session('books')]);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        $title = $request->input('title');
        $author = $request->input('author');
        $books = session('books');
        $id = count($books) + 1;

        session()->push('books', ['id' => $id, 'title' => $title, 'author' => $author]);

        return redirect()->route('books.index');
    }

    public function show(string $id)
    {
        $book = collect(session('books'))->firstWhere('id', $id);

        if (!$book) {
            abort(404);
        }
        return view('books.show', ['book' => $book]);
    }

    public function edit(string $id)
    {
        $book = collect(session('books'))->firstWhere('id', $id);

        if (!$book) {
            abort(404);
        }
        return view('books.edit', ['book' => $book]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
        ]);

        $books = session('books');
        $book = collect($books)->firstWhere('id', $id);

        if (!$book) {
            abort(404);
        }

        $updatedBooks = collect($books)->map(function ($b) use ($id, $request) {
            if ($b['id'] == $id) {
                return [
                    'id' => $id,
                    'title' => $request->input('title'),
                    'author' => $request->input('author'),
                ];
            }
            return $b;
        });

        session(['books' => $updatedBooks->toArray()]);

        return redirect()->route('books.index');
    }

    public function destroy(string $id)
    {
        $books = session('books');
        $book = collect($books)->firstWhere('id', $id);

        if (!$book) {
            abort(404);
        }

        $updatedBooks = collect($books)->reject(function ($b) use ($id) {
            return $b['id'] == $id;
        });

        session(['books' => $updatedBooks->values()->toArray()]);

        return redirect()->route('books.index');
    }
}
