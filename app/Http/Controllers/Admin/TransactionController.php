<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use \Carbon\Carbon;
use Validator;

class TransactionController extends Controller
{
    //initiate
    public function get_book() {
        $book = DB::table('books')
            ->select('book_name', 'id')
            ->get();

        return $book;
    }

    public function get_stock($book_id) {
        $book = DB::table('books')
            ->where('id', $book_id)
            ->first();

        $transaction = DB::table('book_transactions')
            ->where(function($query) use ($book_id) {
                $query->where('book_id', $book_id);
                $query->where('status', '<>', 2);
            })
            ->count();

        $stock = $book->stock - $transaction;

        return $stock;
    }

    public function get_transaction() {
        $transaction = DB::table('book_transactions')
            ->leftJoin('users', function($join) {
                $join->on('users.id', '=', 'book_transactions.user_id');
            })
            ->leftJoin('books', function($join) {
                $join->on('books.id', '=', 'book_transactions.book_id');
            })
            ->select('*', 'book_transactions.id as transaction_id')
            ->get();

        return $transaction;
    }

    public function get_user() {
        $user = DB::table('users')
            ->leftJoin('model_has_roles', function($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id');
            })
            ->leftJoin('roles', function($join) {
                $join->on('roles.id', '=', 'model_has_roles.role_id');
            })
            ->where(function($query) {
                $query->where('name', 'user');
            })
            ->select('users.first_name', 'users.last_name', 'users.id as user_id')
            ->get();

            return $user;
    }

    //page
    public function list() {
        $book = $this->get_book();
        $user = $this->get_user();
        $transaction = $this->get_transaction();

        return view('admin.transaction.list', compact('book', 'user', 'transaction'));
    }

    //process

    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            "user" => ['required'],
            "book" => ['required'],
        ]);

        if($validator->fails()) {
            toast()->warning($validator->messages()->all()[0]);
            return redirect()->back();
        }

        $stock = $this->get_stock($request->book);

        if($stock > 0) {
            $create_transaction = DB::table('book_transactions')
                ->insert([
                    "id" => Uuid::uuid4()->toString(),
                    "book_id" => $request->book,
                    "user_id" => $request->user,
                    "status" => 1,
                    "date_deadline" => Carbon::now()->addDays(3),
                    "created_at" => Carbon::now(),
                    "updated_at" => Carbon::now(),
                ]);

                toast()->success("Berhasil melakukan peminjaman buku");
                return redirect()->back();
        }
        else
        {
            toast()->error('Tidak dapat meminjam buku, karena stock tidak tersedia');
            return redirect()->back();
        }
    }

    public function update($id, Request $request) {
        $validator = Validator::make($request->all(), [
            "status" => ['required'],
        ]);

        if($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => $validator->messages()->all()[0],
            ]);
        }

        if($request->status == 2) {
            $update_transaction = DB::table('book_transactions')
                ->where('id', $id)
                ->update([
                    "date_back" => Carbon::now(),
                    "status" => $request->status,
                    "updated_at" => Carbon::now(),
                ]);
        }
        else
        {
            $update_transaction = DB::table('book_transactions')
                ->where('id', $id)
                ->update([
                    "status" => $request->status,
                    "updated_at" => Carbon::now(),
                ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Data berhasil di update",
        ]);
    }
}
