<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\MenuStoreRequest;
use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function Termwind\ValueObjects\text;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::all();
         return view('admin.menus.index', compact('menus'));
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin/menus/create' , compact('categories'));
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        //
        $file = $request->file('image');
        $ext = $file-> getClientOriginalExtension();
        $file_name = 'images' . '_' . time() . '.' . $ext ;
        $file = $file->storeAs('public/categories' , $file_name);

        $menu = new Menu();
        $menu -> name = $request-> name;
        $menu -> price = $request-> price;
        $menu -> description  = $request-> description;
        $menu -> image = $file_name ;
        $menu ->save();

        if ($request->has('categories')){

            $menu -> categories()->attach($request->categories);
        }

        return to_route('admin.menus.index')->with('success', 'Category created successfully.');
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
    public function edit(Menu $menu)
    {
        //
        $categories = Category::all();
        return view('admin/menus/edit' , compact('menu','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
        $request -> validate([
            'name' => 'required',
            'price' => 'required',
            'categories' => 'required',
            'description' => 'required'
        ]);

        $image = $menu -> image ;
        if ($request-> hasFile('image')){
            Storage::delete($menu->image);
            Storage::delete($menu->image);
            $image = $request->file('image')->store('public/categories');
        }

        $menu -> name = $request-> name;
        $menu -> price = $request-> price;
        $menu -> description  = $request-> description;
        $menu -> image = $image ;
        $menu ->save();
        if ($request->has('categories')) {
            $menu->categories()->sync($request->categories);
        }


        return to_route('admin.menus.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        Storage::delete($menu->image);
        $menu->categories()->detach();
        $menu->delete();

        return to_route('admin.menus.index')->with('success', 'Category deleted successfully.');
        //
    }
}
