<?php
// app/Http/Controllers/Form/BaseFormController.php
namespace App\Http\Controllers\Form\Form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

abstract class BaseFormController extends Controller
{
    // The model this controller will work with
    protected $model;

    // Validation rules (to be defined in child classes)
    protected $createRules = [];
    protected $updateRules = [];

    /**
     * Constructor to set the model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of resources
     */
    public function index(Request $request)
    {
        // Basic pagination with optional filtering
        $query = $this->model->newQuery();

        // Optional search
        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Optional sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');
        $query->orderBy($sortBy, $sortDirection);

        // Paginate results
        $results = $query->paginate($request->get('per_page', 15));

        return view($this->getViewPath('index'), compact('results'));
    }

    /**
     * Show the form for creating a new resource
     */
    public function create()
    {
        // Authorize creation
        $this->authorize('create', $this->model);

        return view($this->getViewPath('create'));
    }

    /**
     * Store a newly created resource
     */
    public function store(Request $request)
    {
        // Authorize creation
        $this->authorize('create', $this->model);

        // Validate input
        $validatedData = $this->validate($request, $this->createRules);

        // Add user_id if applicable
        if (method_exists($this->model, 'user')) {
            $validatedData['user_id'] = Auth::id();
        }

        // Create the resource
        $resource = $this->model->create($validatedData);

        // Redirect with success message
        return redirect()
            ->route($this->getRouteName('show'), $resource)
            ->with('success', 'Resource created successfully');
    }

    /**
     * Display the specified resource
     */
    public function show($id)
    {
        $resource = $this->model->findOrFail($id);

        // Optional authorization
        $this->authorize('view', $resource);

        return view($this->getViewPath('show'), compact('resource'));
    }

    /**
     * Show the form for editing the specified resource
     */
    public function edit($id)
    {
        $resource = $this->model->findOrFail($id);

        // Authorize editing
        $this->authorize('update', $resource);

        return view($this->getViewPath('edit'), compact('resource'));
    }

    /**
     * Update the specified resource
     */
    public function update(Request $request, $id)
    {
        $resource = $this->model->findOrFail($id);

        // Authorize update
        $this->authorize('update', $resource);

        // Validate input
        $validatedData = $this->validate($request, $this->updateRules);

        // Update the resource
        $resource->update($validatedData);

        // Redirect with success message
        return redirect()
            ->route($this->getRouteName('show'), $resource)
            ->with('success', 'Resource updated successfully');
    }

    /**
     * Remove the specified resource
     */
    public function destroy($id)
    {
        $resource = $this->model->findOrFail($id);

        // Authorize deletion
        $this->authorize('delete', $resource);

        // Soft delete if the model uses SoftDeletes
        if (method_exists($resource, 'trashed')) {
            // If already soft deleted, force delete
            if ($resource->trashed()) {
                $resource->forceDelete();
                $message = 'Resource permanently deleted';
            } else {
                // Soft delete
                $resource->delete();
                $message = 'Resource moved to trash';
            }
        } else {
            // Hard delete for models without soft delete
            $resource->delete();
            $message = 'Resource deleted successfully';
        }

        // Determine the appropriate redirect
        $redirectRoute = $this->getRouteName('index');

        // Ajax/API request handling
        if (request()->expectsJson()) {
            return response()->json([
                'message' => $message,
                'deleted' => true
            ]);
        }

        // Web request handling
        return redirect()
            ->route($redirectRoute)
            ->with('success', $message);
    }

    /**
     * Helper method to generate view paths
     * Can be overridden in child classes
     */
    protected function getViewPath(string $view): string
    {
        // Converts model name to kebab-case for view naming
        $modelName = strtolower(class_basename($this->model));
        return "{$modelName}.{$view}";
    }

    /**
     * Helper method to generate route names
     * Can be overridden in child classes
     */
    protected function getRouteName(string $action): string
    {
        $modelName = strtolower(class_basename($this->model));
        return "{$modelName}.{$action}";
    }
}