<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Projects;
use App\Tasks;
use Illuminate\Http\Request;
use DataTables;
use Session;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request)
    {
        $projects = Projects::with('tasks')->where("status", "active");
        if ($request->has('project_id') && $request->project_id != "") {
            $projects->where("id", $request->project_id);
        }
        $projects = $projects->get();

        $filters = Projects::where("status", "active")->pluck("name", "id")->toArray();
        $filters = ['' => 'All'] + $filters;
        return view('tasks.index', compact('projects', 'filters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        $projects = Projects::where("status", "active")->pluck("name", "id")->toArray();
        return view('tasks.create', compact('projects'));
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
            'name' => 'required',
            'content' => 'required',
            'project_id' => 'required',
        ]);

        $data = $request->all();
        $user = Tasks::create($data);

        Session::flash('flash_success', __('User added!'));
        return redirect('tasks');
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
        $item = Tasks::where("id", $id)->first();

        if (!$item) {
            Session::flash('flash_message', 'No Access !');
            return redirect()->back();
        }
        return view('tasks.show', compact('item'));
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
        $item = Tasks::where("id", $id)->first();
        if (!$item) {
            Session::flash('flash_message', 'No Access !');
            return redirect()->back();
        }

        $projects = Projects::where("status", "active")->pluck("name", "id")->toArray();
        return view('tasks.edit', compact('item', 'projects'));
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
            'name' => 'required',
            'content' => 'required',
            'project_id' => 'required',
        ]);

        $item = Tasks::where("id", $id)->first();

        if (!$item) {
            Session::flash('flash_message', 'No Access !');
            return redirect()->back();
        }

        $data = $request->all();
        $item->update($data);
        $item->save();

        Session::flash('flash_success', __('Item updated!'));
        return redirect('tasks');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return void
     */
    public function destroy($id, Request $request)
    {
        $item = Tasks::where("id", $id)->first();
        if ($item) {
            $item->delete();
            Session::flash('flash_success', "Task Deleted!");
        } else {
            Session::flash('flash_error', "Data not found");
        }
        return redirect('tasks');
    }

    /**
     * Reset priority of tasks of specific project.
     *
     * @param  array $dataarray
     *
     * @return json
     */
    public function resetPriority(Request $request)
    {
        $result = array();
        $total = 0;
        $inputs = $request->dataarray;
        foreach ($inputs as $input) {
            $item = Tasks::where("id", $input['id'])->first();
            if ($item) {
                if ($item->priority != $input['priority']) {
                    $item->priority = $input['priority'];
                    $item->save();
                    $total++;
                }
            }
        }

        if ($total) {
            $result['message'] = "Priority Reset, Total Affected Rows = " . $total;
            $result['code'] = 200;
        } else {
            $result['message'] = "Data not found";
            $result['code'] = 200;
        }
        return response()->json($result, $result['code']);
    }
}
