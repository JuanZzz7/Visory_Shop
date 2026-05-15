<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index()
    {
        $company  = Auth::user()->company;
        $expenses = $company ? $company->expenses()->latest()->paginate(15) : collect();
        return view('business.expenses.index', compact('expenses', 'company'));
    }

    public function create() { return view('business.expenses.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'concept'     => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        $company = Auth::user()->company;
        if (!$company) abort(403);

        $company->expenses()->create($request->only('concept', 'amount', 'date', 'description'));
        return redirect()->route('business.expenses.index')->with('success', 'Egreso registrado.');
    }

    public function destroy(Expense $expense)
    {
        if ($expense->company_id !== Auth::user()->company?->id) abort(403);
        $expense->delete();
        return back()->with('success', 'Egreso eliminado.');
    }
}
