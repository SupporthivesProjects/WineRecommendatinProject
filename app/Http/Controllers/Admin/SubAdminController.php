<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubadminFeature;
use App\Models\SubadminFeaturePermission;
use App\Models\User;

use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    /**
     * Display all sub admin features.
     */
    public function index()
    {
        $subAdmins = User::where('role', 'sub_admin')
        ->orderBy('first_name')
        ->get();

        return view('admin.subadmin.index', compact('subAdmins'));
    }
    public function edit($id)
    {
        $subAdmin = User::findOrFail($id);

        $features = SubadminFeature::orderBy('id')->get();
    
        $assignedFeatures = SubadminFeaturePermission::where('sub_admin_id', $id)
            ->pluck('feature_id')
            ->toArray();
    
        return view('admin.subadmin.edit', compact(
            'subAdmin',
            'features',
            'assignedFeatures'
        ));
    }

    /**
     * Update sub admin feature permissions.
     */
    public function update(Request $request, $id)
    {
        try {

            SubadminFeaturePermission::where('sub_admin_id', $id)->delete();

            if ($request->has('features')) {

                foreach ($request->features as $featureId) {

                    SubadminFeaturePermission::create([
                        'sub_admin_id' => $id,
                        'feature_id'   => $featureId,
                    ]);
                }
            }

            return redirect()
                ->back()
                ->with('success', 'Permissions updated successfully.');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with('error', 'Something went wrong while updating permissions.');
                // ->with('error', $e->getMessage()); // Useful during development only
        }
    }

    /**
     * Enable all features.
     */
    public function enableAll()
    {
        //
    }

    /**
     * Disable all features.
     */
    public function disableAll()
    {
        //
    }
}
