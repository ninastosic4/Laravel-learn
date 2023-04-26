<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoriesController extends Controller
{
    // kontroler za kategorije
    public function __construct()
    {
        // auth znaci da moras biti ulogovan da mi prisao akciji
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        // validate
        $data = request()->validate([
            'name' => 'required|string|min:3|max:20',
            'description' => 'required|string|min:10|max:255',
            'text' => 'nullable|string|max:65000'
        ]);

        $data['active'] = 1;

        $categories = Category::all();
        if(count($categories) > 0) {
            $lastPriority = Category::max('priority');
            $data['priority'] = $lastPriority + 1;
        } else {
            $lastPriority = 0;
        }


        // save data into database
        Category::create($data);

        // redirect with a message
        return redirect()
                ->route('categories.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('categories.created-success')
                ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category)
    {
        // validate
        $data = request()->validate([
            'name' => 'required|string|min:3|max:20',
            'description' => 'required|string|min:10|max:255',
            'text' => 'nullable|string|max:65000'
        ]);

        // save changes into database
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->text = $data['text'];

        $category->save();

        // redirect with a message
        return redirect()
                ->route('categories.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('categories.updated-success')
                ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // delete the category
        $category->delete();
        // redirect to the list of all categories
        return redirect()
                ->route('categories.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('categories.delete-success')
        ]);
    }

    public function status(Category $category){

        if($category->active == 1){
            $category->active = 0;
        } else {
            $category->active = 1;
        }
        $category->save();

        // redirekcija
        return redirect()
                ->route('categories.index')
                ->with('message', [
                    'type' => 'text-success',
                    'text' => trans('categories.changed-status')
                ]);
    }
}
