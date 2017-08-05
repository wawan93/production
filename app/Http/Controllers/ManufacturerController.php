<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Manufacturer;
use Illuminate\Http\Request;
use Session;

class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $manufacturer = Manufacturer::where('short_name', 'LIKE', "%$keyword%")
				->orWhere('full_name', 'LIKE', "%$keyword%")
				->orWhere('full_name_decl', 'LIKE', "%$keyword%")
				->orWhere('inn', 'LIKE', "%$keyword%")
				->orWhere('domicile', 'LIKE', "%$keyword%")
				->orWhere('contact', 'LIKE', "%$keyword%")
				->orWhere('email', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $manufacturer = Manufacturer::paginate($perPage);
        }

        return view('manufacturer.index', compact('manufacturer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('manufacturer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        
        $requestData = $request->all();
        
        Manufacturer::create($requestData);

        Session::flash('flash_message', 'Manufacturer added!');

        return redirect('manufacturer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);

        return view('manufacturer.show', compact('manufacturer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);

        return view('manufacturer.edit', compact('manufacturer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        
        $requestData = $request->all();
        
        $manufacturer = Manufacturer::findOrFail($id);
        $manufacturer->update($requestData);

        Session::flash('flash_message', 'Manufacturer updated!');

        return redirect('manufacturer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Manufacturer::destroy($id);

        Session::flash('flash_message', 'Manufacturer deleted!');

        return redirect('manufacturer');
    }
}
