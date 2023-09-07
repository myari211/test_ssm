<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Ramsey\Uuid\Uuid;
use \Carbon\Carbon;

class BookController extends Controller
{
    //initiate function
    public function get_category() {
        $category = DB::table('book_categories')
            ->get();

        return $category;
    }

    public function get_book() {
        $book = DB::table('books')
            ->leftJoin('book_categories', function($join) {
                $join->on('book_categories.id', '=', 'books.category');
            })
            ->get();

        return $book;
    }

    //page
    public function book_category() {
        $category = $this->get_category();

        return view('admin.book.category', compact('category'));
    }

    public function create_category(Request $request) {
        $validator = Validator::make($request->all(), [
            "category" => ['required'],
        ]);

        if($validator->fails()) {
            toast()->warning($validator->messages()->all()[0]);
            return redirect()->back();
        }

        $create_category = DB::table('book_categories')
            ->insert([
                "category_name" => $request->category,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

        toast()->success('Data Kategory berhasil dibuat');
        return redirect()->back();
    }

    public function list() {
        $category = $this->get_category();
        $book = $this->get_book();

        return view('admin.book.list', compact('category', 'book'));
    }

    public function create_book(Request $request) {
        $validator = Validator::make($request->all(), [
            "book_name" => ['required', 'min:3'],
            "synopsis" => ['required', 'min: 10'],
            "author" => ['required'],
            "year" => ['required'],
            "category" => ['required'],
            "stock" => ['required'],
        ]);

        if($validator->fails()) {
            toast()->warning($validator->messages()->all()[0]);
            return redirect()->back();
        }

        $createBook = DB::table('books')
            ->insert([
                "id" => Uuid::uuid4()->toString(),
                "book_name" => $request->book_name,
                "synopsis" => $request->synopsis,
                "author" => $request->author,
                "year" => $request->year,
                "category" => $request->category,
                "stock" => $request->stock,
                "image" => $request->image,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ]);

        toast()->success('Data Buku Berhasil dibuat');
        return redirect()->back();
    }
}
