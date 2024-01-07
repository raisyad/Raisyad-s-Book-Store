<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookCategoryRequest;
use App\Models\BookCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class BooksCategoryController extends Controller
{
    public function index() {
        $books_category = BookCategory::paginate(4);
        return view('pages/BookCategory', ['catlist' => $books_category, 'titles' => 'Books Category']);
    }

    public function create() {
        return view('pages/BookCategoryAdd', ['titles' => 'Add New Category Book']);
    }

    public function store(BookCategoryRequest $request) {
        $bookCat = BookCategory::create([
            'category' => $request->categoryNew,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if($bookCat) {
            Session::flash('statusSuccess', 'inputed');
            Session::flash('message', "Data Category {$request->categoryNew} Berhasil dibuat");
        }

        return redirect('/bookscat');
    }

    public function edit($id) {
        $bookCat = BookCategory::findOrFail($id);
        return view('pages/BookCategoryEdit', ['specifyBookCat' => $bookCat, 'titles' => 'Update Category Book']);
    }

    public function update($id, Request $request) {
        $bookCat = BookCategory::findOrFail($id);
        $tempCat = $bookCat->category;
        $bookCat->category = $request->categoryEdit;
        $tempCatUpdated = $bookCat->category;
        $bookCat->updated_at = Carbon::now();

        $bookCat->save();

        if($bookCat) {
            Session::flash('statusSuccess', 'updated');
            Session::flash('message', "Data Category {$tempCat} Berhasil diubah menjadi {$tempCatUpdated}");
        }

        return redirect('/bookscat');
    }

    public function destroy($id) {
        $deletedCat = BookCategory::findOrFail($id);
        $deletedCat->delete();

        if($deletedCat) {
            Session::flash('statusSuccess', 'deleted');
            Session::flash('message', "Data Category {$deletedCat->category} Berhasil dihapus");
        }

        return redirect('/bookscat');
    }
}
