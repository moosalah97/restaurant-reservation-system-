<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableStoreRequest;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $tables = Table::all();
        return view('admin.tables.index' , compact('tables'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin/tables/create' );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TableStoreRequest $request)
    {
        //
        $table = new Table();
        $table -> name = $request-> name;
        $table -> guest_number = $request-> guest_number;
        $table -> status  = $request-> status;
        $table -> location  = $request-> location;
        $table ->save();

        return to_route('admin.tables.index')->with('success', 'Table created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        //
        return view('admin/tables/edit' , compact('table'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TableStoreRequest $request , Table $table )
    {
        //
        $table->update($request->validated());

        return to_route('admin.tables.index')->with('success', 'Table updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        //
        Storage::delete($table) ;
        $table -> delete();

        return to_route('admin.tables.index')->with('success', 'Table deleted successfully.');
        //
    }
}
