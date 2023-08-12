<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Projects;
use Illuminate\Http\Request;
use DataTables;
use Session;

class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function dataTable(Request $request)
    {
        $record = Projects::where('id', '>', 0);

        if ($request->has('status') && $request->status != "") {
            $record->where("status", $request->status);
        }
        return Datatables::of($record)->make(true);
    }

    public function index(Request $request)
    {
        return view('projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'name' => 'required|unique:projects',
        ]);

        $data = $request->all();
        Projects::create($data);

        Session::flash('flash_success', __('User added!'));
        return redirect('projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return void
     */
    public function show($id)
    {
        $item = Projects::where("id", $id)->first();

        if (!$item) {
            Session::flash('flash_message', 'No Access !');
            return redirect()->back();
        }
        return view('projects.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return void
     */
    public function edit($id)
    {
        $item = Projects::where("id", $id)->first();
        if (!$item) {
            Session::flash('flash_message', 'No Access !');
            return redirect()->back();
        }
        return view('projects.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'status' => 'required',
            'name' => 'required|unique:projects,name,' . $id,
        ]);

        $item = Projects::where("id", $id)->first();

        if (!$item) {
            Session::flash('flash_message', 'No Access !');
            return redirect()->back();
        }

        $data = $request->all();
        $item->update($data);
        $item->save();

        Session::flash('flash_success', __('Item updated!'));
        return redirect('projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return void
     */
    public function destroy($id)
    {
        $result = array();
        $item = Projects::where("id", $id)->first();

        if ($item) {
            if ($item->tasks->count() > 0) {
                $result['message'] = "Some Task Exist Under Project " . $item->name;
                $result['code'] = 400;
            } else {
                $item->delete();
                $result['message'] = "Item deleted!";
                $result['code'] = 200;
            }
        } else {
            $result['message'] = "Data not found";
            $result['code'] = 400;
        }

        return response()->json($result, $result['code']);
    }
}
