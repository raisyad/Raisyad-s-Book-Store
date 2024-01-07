<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $keyword = $request->catId;
        $keywordAllBooks = $request->catIdAllBooks;
        $flag = false;

        // Kalo search bar 1
        if ($keyword) {
            $books = Book::with('user', 'category')
                ->where('users_id_created', $userId)
                ->where('book_category_id', $keyword)
                ->paginate(2, ['*'], 'books');
            $allBooks = Book::paginate(2, ['*'], 'allBooks');
            if ($books->isEmpty()) {
                Session::flash('flashData', [
                    'status' => 'nullDataYourBook',
                    'message' => 'No related data',
                ]);
                if ($allBooks->isEmpty()) {
                    Session::flash('flashData', [
                        'status' => 'nullDataYourBook',
                        'message' => 'There was never a book made',
                        'status1' => 'noHaveDataBook',
                        'message1' => 'You Never Created Book',
                    ]);
                }
                $flag = true;
            }

        // Kalo search bar 2
        } else if ($keywordAllBooks) {
            $books = Book::with('user', 'category')
                ->where('users_id_created', $userId)
                ->paginate(2, ['*'], 'books');
            $allBooks = Book::where('book_category_id', $keywordAllBooks)
                ->paginate(2, ['*'], 'allBooks');

            if ($allBooks->isEmpty()) {
                Session::flash('flashData', [
                    'status' => 'nullDataAllBook',
                    'message' => 'No related data',
                ]);
                if ($books->isEmpty()) {
                    Session::flash('flashData', [
                        'status' => 'nullDataAllBook',
                        'message' => 'No related data',
                        'status1' => 'noHaveDataBook',
                        'message1' => 'You Never Created Book',
                    ]);
                }
                $flag = true;
            }
        } else {
            $books = Book::with('user', 'category')
                ->where('users_id_created', $userId)
                ->paginate(2, ['*'], 'books');
            $allBooks = Book::paginate(2, ['*'], 'allBooks');
        }

        $booksCat = BookCategory::all();

        if (!$flag) {
            if ($books->isEmpty()) {
                Session::flash('flashData', [
                    'status1' => 'noHaveDataBook',
                    'message1' => 'You Never Created Book',
                ]);
                if ($allBooks->isEmpty()) {
                    Session::flash('flashData', [
                        'status' => 'noHaveDataAllBook',
                        'message' => 'There was never a book made',
                        'status1' => 'noHaveDataBook',
                        'message1' => 'You Never Created Book',
                    ]);
                }
            } else if ($allBooks->isEmpty()) {
                Session::flash('flashData', [
                    'status1' => 'noHaveDataAllBook',
                    'message1' => 'There was never a book made',
                ]);
                if ($books->isEmpty()) {
                    Session::flash('flashData', [
                        'status' => 'noHaveDataAllBook',
                        'message' => 'No related data',
                        'status1' => 'noHaveDataBook',
                        'message1' => 'You Never Created Book',
                    ]);
                }
            }
        }

        $users = Users::all();
        return view('pages.Book', [
            'usersList' => $users,
            'books' => $books,
            'booksCat' => $booksCat,
            'allBooks' => $allBooks,
            'titles' => 'Beranda'
        ]);
    }

    public function show($id)
    {
        $bookDetails = Book::with([
            'category:id,category',
            'users:id,name,role_id:id,type_role',
        ])->findOrFail($id);
        return view('pages.BookView', ['bookDetails' => $bookDetails, 'titles' => 'Detail View Book']);
    }

    public function create()
    {
        $catBooks = BookCategory::select('id', 'category')
            ->orderBy('id', 'asc')
            ->get();
        return view('pages/BookAdd', ['catBooks' => $catBooks, 'titles' => 'Add New Book']);
    }

    public function store(BookRequest $request)
    {
        $newName = '';
        $newNamePdf = '';

        if ($request->file('cover')) {
            $ext = $request->file('cover')->getClientOriginalExtension();
            $newName = 'images' . '_cover_' . now()->timestamp . '.' . $ext;
            $request->file('cover')->storeAs('images', $newName);
        }

        if ($request->file('pdf')) {
            $extPdf = $request->file('pdf')->getClientOriginalExtension();
            $newNamePdf = 'documents' . '_book_' . now()->timestamp . '.' . $extPdf;
            $request->file('pdf')->storeAs('documents', $newNamePdf);
        }

        $book = Book::create([
            'title' => $request->title,
            'book_category_id' => $request->catId,
            'description' => $request->description,
            'count' => $request->count,
            'pdf_file' => $newNamePdf,
            'book_cover' => $newName,
            'users_id_created' => $request->userId
        ]);

        if ($book) {
            Session::flash('status', 'inputed');
            Session::flash('message', "Data Book {$request->title} Berhasil dibuat");
        }

        return redirect('/books');
    }

    public function edit($id)
    {
        $book = Book::with([
            'category:id,category',
            'users:id,name,role_id:id,type_role',
        ])->findOrFail($id);
        $catBooks = BookCategory::where('id', '!=', $book->category->id)->get(['id', 'category']);
        return view('pages/BookEdit', ['specifyBook' => $book, 'catBooks' => $catBooks, 'titles' => 'Update Book']);
    }

    public function update($id, BookRequest $request)
    {
        $book = Book::findOrFail($id);

        $newName = '';
        $newNamePdf = '';
        if ($request->cover != '') {

            if ($request->file('cover')) {
                $ext = $request->file('cover')->getClientOriginalExtension();
                $newName = 'images' . '_cover_' . now()->timestamp . '.' . $ext;
                $request->file('cover')->storeAs('images', $newName);
            }
        }

        if ($request->file('pdf')) {
            $extPdf = $request->file('pdf')->getClientOriginalExtension();
            $newNamePdf = 'documents' . '_book_' . now()->timestamp . '.' . $extPdf;
            $request->file('pdf')->storeAs('documents', $newNamePdf);
        }

        $temp = $request->title;
        if ($book->title != $request->title) $temp = $book->title;

        $book->title = $request->title;
        $book->book_category_id = $request->catId;
        $book->description = $request->description;
        $book->count = $request->count;
        if($request->pdf != '') $book->pdf_file = $newNamePdf;

        if ($newName) $book->book_cover = $newName;

        $book->updated_at = Carbon::now();
        $book->save();

        if ($book) {
            Session::flash('status', 'updated');

            if ($temp != $request->title && $newName)
                Session::flash('message', "Data Book yang sebelumnya {$temp} Berhasil diupdate");
            else if ($temp != $request->title)
                Session::flash('message', "Data Book {$temp} Berhasil diubah menjadi {$request->title}");
            else if ($newName)
                Session::flash('message', "Data Book {$temp} Berhasil mengubah cover");
            else
                Session::flash('message', "Data mengenai Book {$temp} ada yang diupdate");
        }

        return redirect('/books');
    }

    public function destroy($id)
    {
        $deletedBook = Book::findOrFail($id);
        $deletedBook->delete();

        if ($deletedBook) {
            Session::flash('status', 'deleted');
            Session::flash('message', "Data Book {$deletedBook->title} Berhasil dihapus");
        }

        return redirect('/books');
    }

    public function show_pdf($id)
    {
        $bookDetails = Book::with([
            'category:id,category',
            'users:id,name,role_id:id,type_role',
        ])->findOrFail($id);
        return view('pages.BookExportPDF', ['bookDetails' => $bookDetails, 'titles' => 'Detail View Book']);
    }

    public function export_pdf($id)
    {
        $bookDetails = Book::with([
            'category:id,category',
            'users:id,name,role_id:id,type_role',
        ])->findOrFail($id);

        $pdf = PDF::loadView('pages.BookExportPDF', [
            'titles' => 'Detail View Book',
            'bookDetails' => $bookDetails,
        ]);
        $path = storage_path('app/public/documents/documents_' . $bookDetails->title . '_' . now()->timestamp . '-temp.pdf');
        $pdf->save($path);
        
        $originalPdfPath = public_path('storage/documents/' . $bookDetails->pdf_file);

        $mergedPdfPath = storage_path('app/public/documents/documents_' . $bookDetails->title . '_' . now()->timestamp . '-merged.pdf');
        $this->mergePdfs($originalPdfPath, $path, $mergedPdfPath);
        unlink($path);

        return response()->download($mergedPdfPath);
    }

    private function mergePdfs(string $originalPath, string $tempPath, string $outputPath)
    {
        $pdfMerger = PDFMerger::init();
        $pdfMerger->addPDF($tempPath);
        $pdfMerger->addPDF($originalPath);
        $pdfMerger->merge();

        $pdfMerger->save($outputPath);
    }
}
