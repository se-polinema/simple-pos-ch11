<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function __invoke(Request $request): View
    {
        $q = trim((string) $request->string('q'));
        $user = $request->user();
        $limit = 10;

        $products = collect();
        $productsTotal = 0;
        $transactions = collect();
        $transactionsTotal = 0;
        $users = collect();
        $usersTotal = 0;

        if ($q !== '') {
            $productQuery = Product::with('category')
                ->where(fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('sku', 'like', "%{$q}%"));
            $productsTotal = $productQuery->count();
            $products = (clone $productQuery)->limit($limit)->get();

            $transactionQuery = Transaction::with('user')
                ->where('invoice_no', 'like', "%{$q}%")
                ->when(! $user->isAdmin(), fn ($qr) => $qr->where('user_id', $user->id));
            $transactionsTotal = $transactionQuery->count();
            $transactions = (clone $transactionQuery)->limit($limit)->get();

            // User search is admin-only — a kasir has no business seeing other accounts.
            if ($user->isAdmin()) {
                $userQuery = User::where(fn ($w) => $w->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%"));
                $usersTotal = $userQuery->count();
                $users = (clone $userQuery)->limit($limit)->get();
            }
        }

        return view('search.index', compact(
            'q', 'products', 'productsTotal', 'transactions', 'transactionsTotal', 'users', 'usersTotal'
        ));
    }
}
