<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $records = Auth::user()->records()->latest()->paginate(10)->withQueryString();

        $editRecord = null;
        if ($editId = $request->query('edit') ?? session('edit_record_id')) {
            $editRecord = Auth::user()->records()->find($editId);
        }

        return view('records.index', compact('records', 'editRecord'));
    }

    public function create()
    {
        return redirect()
            ->route('records.index')
            ->with('open_record_modal', 'add');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('records.index')
                ->withInput()
                ->withErrors($validator)
                ->with('open_record_modal', 'add');
        }

        Auth::user()->records()->create($validator->validated());

        return redirect()->route('records.index')->with('success', 'Record added successfully.');
    }

    public function edit(Record $record)
    {
        $this->authorizeRecord($record);

        return redirect()->route('records.index', ['edit' => $record->id]);
    }

    public function update(Request $request, Record $record)
    {
        $this->authorizeRecord($record);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('records.index')
                ->withInput()
                ->withErrors($validator)
                ->with('edit_record_id', $record->id)
                ->with('open_record_modal', 'edit');
        }

        $record->update($validator->validated());

        return redirect()->route('records.index')->with('success', 'Record updated successfully.');
    }

    public function destroy(Record $record)
    {
        $this->authorizeRecord($record);
        $this->ensureCanDelete();
        $record->delete();

        return redirect()->route('records.index')->with('success', 'Record deleted successfully.');
    }

    protected function authorizeRecord(Record $record)
    {
        if ($record->user_id !== Auth::id()) {
            abort(403);
        }
    }
}
