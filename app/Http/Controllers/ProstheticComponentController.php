<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProstheticComponent;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ProstheticComponentController extends Controller
{
    // Display a listing of prosthetic components
    public function index()
    {
        try {
            $components = ProstheticComponent::orderBy('created_at', 'desc')
                                           ->paginate(15);
            
            return view('componentdevice.adminlist', compact('components'));
        } catch (\Exception $e) {
            Log::error('Failed to load components list: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Failed to load components list.');
        }
    }

    // Show the form to create a new prosthetic component
    public function create()
    {
        return view('componentdevice.admincreate');
    }

    // Store the newly created prosthetic component
    public function store(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'type' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'compatibility' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'weight_min' => 'nullable|integer|min:0',
            'weight_max' => 'nullable|integer|min:0|gte:weight_min',
            'description' => 'required|string',
            'age_min' => 'nullable|integer|min:0|max:120',
            'age_max' => 'nullable|integer|min:0|max:120|gte:age_min',
            'klevel_range' => 'nullable|string|max:255',
            'bscore_min' => 'nullable|integer|min:0|max:30',
            'bscore_max' => 'nullable|integer|min:0|max:30|gte:bscore_min',
            'is_active' => 'required|boolean',
        ], [
            // Custom error messages
            'name.required' => 'Component name is required.',
            'name.min' => 'Component name must be at least 3 characters.',
            'type.required' => 'Component type is required.',
            'description.required' => 'Component description is required.',
            'is_active.required' => 'Component status is required.',
            'weight_max.gte' => 'Maximum weight must be greater than or equal to minimum weight.',
            'age_max.gte' => 'Maximum age must be greater than or equal to minimum age.',
            'bscore_max.gte' => 'Maximum BScore must be greater than or equal to minimum BScore.',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->route('admin.component.create')
                             ->withErrors($validator)
                             ->withInput();
        }

        try {
            // Store the prosthetic component
            $component = ProstheticComponent::create([
                'name' => $request->name,
                'type' => $request->type,
                'size' => $request->size,
                'compatibility' => $request->compatibility,
                'material' => $request->material,
                'weight_min' => $request->weight_min,
                'weight_max' => $request->weight_max,
                'description' => $request->description,
                'age_min' => $request->age_min,
                'age_max' => $request->age_max,
                'klevel_range' => $request->klevel_range,
                'bscore_min' => $request->bscore_min,
                'bscore_max' => $request->bscore_max,
                'is_active' => $request->is_active,
            ]);

            Log::info('Prosthetic component created successfully', ['component_id' => $component->compID]);

            // Redirect to index page with success message
            return redirect()->route('admin.component.index')
                           ->with('success', 'Prosthetic component created successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to create prosthetic component: ' . $e->getMessage());
            // If there's an error during creation, redirect back with error
            return redirect()->route('admin.component.create')
                           ->with('error', 'Failed to create component. Please try again.')
                           ->withInput();
        }
    }

    // Display the specified prosthetic component
    public function show($id)
    {
        try {
            $component = ProstheticComponent::findOrFail($id);
            return view('componentdevice.adminview', compact('component'));
        } catch (\Exception $e) {
            Log::error('Component not found: ' . $e->getMessage(), ['component_id' => $id]);
            return redirect()->route('admin.component.index')
                           ->with('error', 'Component not found.');
        }
    }

    // Show the form for editing the specified prosthetic component
    public function edit($id)
    {
        try {
            $component = ProstheticComponent::findOrFail($id);
            return view('componentdevice.adminupdate', compact('component'));
        } catch (\Exception $e) {
            Log::error('Component not found for editing: ' . $e->getMessage(), ['component_id' => $id]);
            return redirect()->route('admin.component.index')
                           ->with('error', 'Component not found.');
        }
    }

    // Update the specified prosthetic component
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'type' => 'required|string|max:255',
            'size' => 'nullable|string|max:255',
            'compatibility' => 'nullable|string|max:255',
            'material' => 'nullable|string|max:255',
            'weight_min' => 'nullable|integer|min:0',
            'weight_max' => 'nullable|integer|min:0|gte:weight_min',
            'description' => 'required|string',
            'age_min' => 'nullable|integer|min:0|max:120',
            'age_max' => 'nullable|integer|min:0|max:120|gte:age_min',
            'klevel_range' => 'nullable|string|max:255',
            'bscore_min' => 'nullable|integer|min:0|max:30',
            'bscore_max' => 'nullable|integer|min:0|max:30|gte:bscore_min',
            'is_active' => 'required|boolean',
        ], [
            // Custom error messages
            'name.required' => 'Component name is required.',
            'name.min' => 'Component name must be at least 3 characters.',
            'type.required' => 'Component type is required.',
            'description.required' => 'Component description is required.',
            'is_active.required' => 'Component status is required.',
            'weight_max.gte' => 'Maximum weight must be greater than or equal to minimum weight.',
            'age_max.gte' => 'Maximum age must be greater than or equal to minimum age.',
            'bscore_max.gte' => 'Maximum BScore must be greater than or equal to minimum BScore.',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->route('admin.component.edit', $id)
                             ->withErrors($validator)
                             ->withInput();
        }

        try {
            $component = ProstheticComponent::findOrFail($id);
            
            // Update the prosthetic component
            $component->update([
                'name' => $request->name,
                'type' => $request->type,
                'size' => $request->size,
                'compatibility' => $request->compatibility,
                'material' => $request->material,
                'weight_min' => $request->weight_min,
                'weight_max' => $request->weight_max,
                'description' => $request->description,
                'age_min' => $request->age_min,
                'age_max' => $request->age_max,
                'klevel_range' => $request->klevel_range,
                'bscore_min' => $request->bscore_min,
                'bscore_max' => $request->bscore_max,
                'is_active' => $request->is_active,
            ]);

            Log::info('Prosthetic component updated successfully', ['component_id' => $component->compID]);

            // Redirect to show page with success message
            return redirect()->route('admin.component.show', $component->compID)
                           ->with('success', 'Prosthetic component updated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to update prosthetic component: ' . $e->getMessage(), ['component_id' => $id]);
            return redirect()->route('admin.component.edit', $id)
                           ->with('error', 'Failed to update component. Please try again.')
                           ->withInput();
        }
    }

    // Remove the specified prosthetic component from storage (Soft Delete)
    public function destroy($id)
    {
        try {
            $component = ProstheticComponent::findOrFail($id);
            
            // Soft delete by setting is_active to 0 (false)
            $component->update(['is_active' => false]);
            
            Log::info('Prosthetic component deactivated successfully', ['component_id' => $component->compID]);
            
            return redirect()->route('admin.component.index')
                           ->with('success', 'Prosthetic component deactivated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to deactivate prosthetic component: ' . $e->getMessage(), ['component_id' => $id]);
            return redirect()->route('admin.component.index')
                           ->with('error', 'Failed to deactivate component.');
        }
    }

    // Restore a deactivated component
    public function restore($id)
    {
        try {
            $component = ProstheticComponent::findOrFail($id);
            
            // Restore by setting is_active to 1 (true)
            $component->update(['is_active' => true]);
            
            Log::info('Prosthetic component activated successfully', ['component_id' => $component->compID]);
            
            return redirect()->route('admin.component.index')
                           ->with('success', 'Prosthetic component activated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to activate prosthetic component: ' . $e->getMessage(), ['component_id' => $id]);
            return redirect()->route('admin.component.index')
                           ->with('error', 'Failed to activate component.');
        }
    }

    // Get active components for API or AJAX calls
    public function getActiveComponents()
    {
        try {
            $components = ProstheticComponent::where('is_active', true)
                                           ->orderBy('name')
                                           ->get(['compID', 'name', 'type', 'compatibility']);
            
            return response()->json([
                'success' => true,
                'data' => $components
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve active components: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve components'
            ], 500);
        }
    }

    // Search components (for AJAX search functionality)
    public function search(Request $request)
    {
        try {
            $query = $request->get('q');
            $type = $request->get('type');
            $status = $request->get('status');
            
            $components = ProstheticComponent::query();
            
            if ($query) {
                $components->where(function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%")
                      ->orWhere('material', 'LIKE', "%{$query}%")
                      ->orWhere('compatibility', 'LIKE', "%{$query}%")
                      ->orWhere('description', 'LIKE', "%{$query}%");
                });
            }
            
            if ($type) {
                $components->where('type', $type);
            }
            
            if ($status !== null && $status !== '') {
                $components->where('is_active', $status === '1');
            }
            
            $results = $components->orderBy('name')
                                 ->paginate(10);
            
            return response()->json([
                'success' => true,
                'data' => $results
            ]);
            
        } catch (\Exception $e) {
            Log::error('Component search failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Search failed'
            ], 500);
        }
    }

    // Get component statistics for dashboard
    public function getStatistics()
    {
        try {
            $stats = [
                'total' => ProstheticComponent::count(),
                'active' => ProstheticComponent::where('is_active', true)->count(),
                'inactive' => ProstheticComponent::where('is_active', false)->count(),
                'by_type' => ProstheticComponent::select('type')
                                               ->selectRaw('count(*) as count')
                                               ->groupBy('type')
                                               ->pluck('count', 'type'),
                'recent' => ProstheticComponent::orderBy('created_at', 'desc')
                                             ->take(5)
                                             ->get(['compID', 'name', 'type', 'created_at'])
            ];
            
            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to get component statistics: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get statistics'
            ], 500);
        }
    }

    // Bulk actions for multiple components
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'component_ids' => 'required|array|min:1',
            'component_ids.*' => 'exists:prosthetic_components,compID'
        ]);

        try {
            $componentIds = $request->component_ids;
            $action = $request->action;
            $affectedCount = 0;

            switch ($action) {
                case 'activate':
                    $affectedCount = ProstheticComponent::whereIn('compID', $componentIds)
                                                       ->update(['is_active' => true]);
                    $message = "Successfully activated {$affectedCount} component(s).";
                    Log::info('Bulk activation completed', ['count' => $affectedCount, 'ids' => $componentIds]);
                    break;
                
                case 'deactivate':
                case 'delete': // Both deactivate and delete do the same thing (soft delete)
                    $affectedCount = ProstheticComponent::whereIn('compID', $componentIds)
                                                       ->update(['is_active' => false]);
                    $message = "Successfully deactivated {$affectedCount} component(s).";
                    Log::info('Bulk deactivation completed', ['count' => $affectedCount, 'ids' => $componentIds]);
                    break;
            }

            return redirect()->route('admin.component.index')
                           ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Bulk action failed: ' . $e->getMessage(), ['action' => $request->action, 'ids' => $request->component_ids]);
            return redirect()->route('admin.component.index')
                           ->with('error', 'Bulk action failed. Please try again.');
        }
    }

    // Hard delete a component (permanent deletion - use with caution)
    public function forceDestroy($id)
    {
        try {
            $component = ProstheticComponent::findOrFail($id);
            $componentName = $component->name;
            
            // Permanently delete the component
            $component->delete();
            
            Log::warning('Prosthetic component permanently deleted', ['component_id' => $id, 'name' => $componentName]);
            
            return redirect()->route('admin.component.index')
                           ->with('success', 'Prosthetic component permanently deleted.');

        } catch (\Exception $e) {
            Log::error('Failed to permanently delete prosthetic component: ' . $e->getMessage(), ['component_id' => $id]);
            return redirect()->route('admin.component.index')
                           ->with('error', 'Failed to delete component permanently.');
        }
    }

    // Show components including inactive ones for admin review
    public function showAll()
    {
        try {
            $components = ProstheticComponent::orderBy('created_at', 'desc')
                                           ->paginate(15);
            
            return view('componentdevice.adminlist', compact('components'));
        } catch (\Exception $e) {
            Log::error('Failed to load all components: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Failed to load components list.');
        }
    }

    // Show only active components
    public function showActive()
    {
        try {
            $components = ProstheticComponent::where('is_active', true)
                                           ->orderBy('created_at', 'desc')
                                           ->paginate(15);
            
            return view('componentdevice.adminlist', compact('components'));
        } catch (\Exception $e) {
            Log::error('Failed to load active components: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Failed to load components list.');
        }
    }

    // Show only inactive components
    public function showInactive()
    {
        try {
            $components = ProstheticComponent::where('is_active', false)
                                           ->orderBy('created_at', 'desc')
                                           ->paginate(15);
            
            return view('componentdevice.adminlist', compact('components'));
        } catch (\Exception $e) {
            Log::error('Failed to load inactive components: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                           ->with('error', 'Failed to load components list.');
        }
    }
}