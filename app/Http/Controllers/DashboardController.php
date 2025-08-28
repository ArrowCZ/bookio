<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $bookCount = Auth::user()->books()->count();

        return view('dashboard', [
            'bookCount' => $bookCount,
        ]);
    }
}
