<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\PolygraphyType;
use Illuminate\Http\Request;
use Session;

class PolygraphyTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            $polygraphytype = PolygraphyType::where('type', 'LIKE', "%$keyword%")
				->orWhere('format', 'LIKE', "%$keyword%")
				->orWhere('mat_name', 'LIKE', "%$keyword%")
				->orWhere('mat_descr', 'LIKE', "%$keyword%")
				->orWhere('order_code', 'LIKE', "%$keyword%")
				->orWhere('mat_type', 'LIKE', "%$keyword%")
				->paginate($perPage);
        } else {
            $polygraphytype = PolygraphyType::paginate($perPage);
        }

        return view('polygraphy_type.polygraphy-type.index', compact('polygraphytype'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('polygraphy_type.polygraphy-type.create');
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
        
        PolygraphyType::create($requestData);

        Session::flash('flash_message', 'PolygraphyType added!');

        return redirect('polygraphy-type');
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
        $polygraphytype = PolygraphyType::findOrFail($id);

        return view('polygraphy_type.polygraphy-type.show', compact('polygraphytype'));
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
        $polygraphytype = PolygraphyType::findOrFail($id);

        return view('polygraphy_type.polygraphy-type.edit', compact('polygraphytype'));
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
        
        $polygraphytype = PolygraphyType::findOrFail($id);
        $polygraphytype->update($requestData);

        Session::flash('flash_message', 'PolygraphyType updated!');

        return redirect('polygraphy-type');
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
        PolygraphyType::destroy($id);

        Session::flash('flash_message', 'PolygraphyType deleted!');

        return redirect('polygraphy-type');
    }
}
