<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RecordController extends Controller
{
    public function index(Request $request)
    {
        $records = Record::latest()->paginate(10)->withQueryString();

        $editRecord = null;
        if ($editId = $request->query('edit') ?? session('edit_record_id')) {
            $editRecord = Record::find($editId);
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

        Record::create([
            ...$validator->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('records.index')->with('success', 'Record added successfully.');
    }

    public function edit(Record $record)
    {
        return redirect()->route('records.index', ['edit' => $record->id]);
    }

    public function update(Request $request, Record $record)
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
                ->with('edit_record_id', $record->id)
                ->with('open_record_modal', 'edit');
        }

        $record->update($validator->validated());

        return redirect()->route('records.index')->with('success', 'Record updated successfully.');
    }

    public function destroy(Record $record)
    {
        $record->delete();

        return redirect()->route('records.index')->with('success', 'Record deleted successfully.');
    }
}
