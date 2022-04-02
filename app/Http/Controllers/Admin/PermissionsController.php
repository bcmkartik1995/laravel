<?php

namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;

class PermissionsController extends Controller
{
    /**
    *
    * allow admin only
    *
    */

    public function __construct() {
        $this->middleware('role:admin');
    }

    /**
     * Display a listing of Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = Permission::orderBy('id', 'DESC')->get();
        return view('admin.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating new Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.permissions.create',compact('permissions'));
    }

    /**
     * Store a newly created Permission in storage.
     *
     * @param  \App\Http\Requests\StorePermissionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required','unique:permissions','max:50'],
        ]);

        $data = $request->all();
        if(empty($data['parent'])){
            $data['parent'] = 0;
        }
        // print_R($data);die;
        $permission = Permission::create($data);
        
        return redirect('admin/permissions')->with('Insert_Message', "The $permission->name was saved successfully");
    }


    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        $parents = Permission::all();

        return view('admin.permissions.edit', compact('permission','parents'));
    }

    /**
     * Update Permission in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionsRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'name' => 'required|max:50|unique:permissions,name,'.$id,
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $request->input('name');
        $permission->is_heading = $request->is_heading == '' ? 0 : $request->input('is_heading');
        $permission->parent = $request->parent == '' ? 0 : $request->input('parent');
       
        $permission->update();

        return redirect()->route('permissions.index')->with('update_message', "The $permission->name was updated successfully");
    }


    /**
     * Remove Permission from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permissions.index')->with('delete_message', "The $permission->name was deleted successfully");
    }

    /**
     * Delete all selected Permission at once.
     *
     * @param Request $request
     */
    public function massDestroy(Request $request)
    {
        if ($request->input('ids')) {
            $entries = Permission::whereIn('id', $request->input('ids'))->get();

            foreach ($entries as $entry) {
                $entry->delete();
            }
        }
    }

}
