<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    public function index(Request $request) {
        $userId = Auth::id();
        $keyword = $request->catId;
        $keywordAllBooks = $request->catIdAllBooks;
        
        if($keyword) {
            $books = Book::with('user', 'category')
                        ->where('users_id_created', $userId)
                        ->where('book_category_id', $keyword)
                        ->paginate(2, ['*'], 'books');
            $allBooks = Book::paginate(2, ['*'], 'allBooks');
        } else if ($keywordAllBooks) {
            $books = Book::with('user', 'category')
                        ->where('users_id_created', $userId)
                        ->paginate(2, ['*'], 'books');
            $allBooks = Book::where('book_category_id', $keywordAllBooks)
                            ->paginate(2, ['*'], 'allBooks');
        } else {
            $books = Book::with('user', 'category')
                        ->where('users_id_created', $userId)
                        ->paginate(2, ['*'], 'books');
            $allBooks = Book::paginate(2, ['*'], 'allBooks');
        }

        $booksCat = BookCategory::all();
        if ($books->isEmpty()) {
            Session::flash('statusNever', 'noHaveDataBook');
            Session::flash('messageNever', "You Never Created Book");

            Session::flash('status', 'nullDataYourBook');
            Session::flash('message', "No related data");
        } else {
            Session::flash('status', 'nullDataAllBook');
            Session::flash('message', "No related data");
        }

        $users = Users::all();
        return view('pages.Beranda', [
            'usersList' => $users, 
            'books' => $books, 
            'booksCat' => $booksCat, 
            'allBooks' => $allBooks, 
            'titles' => 'Beranda'
        ]);
    }
}
