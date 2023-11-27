<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    //
    public function index()
    {
        return Location::all();
    }

    public function show($id)
    {
        return Location::find($id);
    }

    public function store(Request $request)
    {
        return Location::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $location = Location::findOrFail($id);
        $location->update($request->all());

        return $location;
    }

    public function destroy($id)
    {
        $location = Location::findOrFail($id);
        $location->delete();

        return 204;
    }
}
