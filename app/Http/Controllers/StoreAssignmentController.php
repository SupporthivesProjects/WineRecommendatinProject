<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;


class StoreAssignmentController extends Controller
{
    public function edit(User $manager)
    {
        // Get all stores where manager id is NULL 
        //$stores = Store::whereNull('manager_id')->get();
        $stores = Store::all();

        // Get store IDs already assigned to this manager 
        $assignedStoreIds = Store::where('manager_id', $manager->id)->pluck('id')->toArray();
        
        return view('store_assignment.edit', compact('manager', 'stores', 'assignedStoreIds'));
    }

    public function update(Request $request, User $manager)
    {
        // Unassign all stores from this manager
        Store::where('manager_id', $manager->id)->update(['manager_id' => null]);

        // Assign selected stores
        if ($request->has('store_ids')) {
            Store::whereIn('id', $request->store_ids)->update(['manager_id' => $manager->id]);
        }

        return redirect()->route('admin.main_manager')->with('success', 'Stores updated successfully.');
    }

}
