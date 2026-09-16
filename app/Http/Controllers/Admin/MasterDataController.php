<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Community;
use App\Models\Country;
use App\Models\Diet;
use App\Models\Height;
use App\Models\Hobby;
use App\Models\Income;
use App\Models\MaritalStatus;
use App\Models\Qualification;
use App\Models\Religion;
use App\Models\State;
use App\Models\WorkingWith;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterDataController extends Controller
{
    /**
     * Map of supported master entities with their configurations.
     */
    protected function getEntityConfig(string $type): ?array
    {
        $normalizedType = str_replace('-', '_', strtolower($type));

        $configs = [
            'countries' => [
                'type' => 'countries',
                'model' => Country::class,
                'singular' => 'Country',
                'plural' => 'Countries',
                'icon' => 'bi-globe-americas',
                'table' => 'countries',
                'has_parent' => false,
                'with' => [],
            ],
            'states' => [
                'type' => 'states',
                'model' => State::class,
                'singular' => 'State',
                'plural' => 'States',
                'icon' => 'bi-geo-alt',
                'table' => 'states',
                'has_parent' => true,
                'parent_key' => 'country_id',
                'parent_relation' => 'country',
                'parent_model' => Country::class,
                'parent_label' => 'Country',
                'with' => ['country'],
            ],
            'cities' => [
                'type' => 'cities',
                'model' => City::class,
                'singular' => 'City',
                'plural' => 'Cities',
                'icon' => 'bi-buildings',
                'table' => 'cities',
                'has_parent' => true,
                'parent_key' => 'state_id',
                'parent_relation' => 'state',
                'parent_model' => State::class,
                'parent_label' => 'State',
                'with' => ['state.country'],
            ],
            'religions' => [
                'type' => 'religions',
                'model' => Religion::class,
                'singular' => 'Religion',
                'plural' => 'Religions',
                'icon' => 'bi-brightness-high',
                'table' => 'religions',
                'has_parent' => false,
                'with' => [],
            ],
            'communities' => [
                'type' => 'communities',
                'model' => Community::class,
                'singular' => 'Community',
                'plural' => 'Communities',
                'icon' => 'bi-people',
                'table' => 'communities',
                'has_parent' => true,
                'parent_key' => 'religion_id',
                'parent_relation' => 'religion',
                'parent_model' => Religion::class,
                'parent_label' => 'Religion',
                'with' => ['religion'],
            ],
            'diets' => [
                'type' => 'diets',
                'model' => Diet::class,
                'singular' => 'Diet',
                'plural' => 'Diets',
                'icon' => 'bi-cup-hot',
                'table' => 'diets',
                'has_parent' => false,
                'with' => [],
            ],
            'heights' => [
                'type' => 'heights',
                'model' => Height::class,
                'singular' => 'Height',
                'plural' => 'Heights',
                'icon' => 'bi-rulers',
                'table' => 'heights',
                'has_parent' => false,
                'with' => [],
            ],
            'hobbies' => [
                'type' => 'hobbies',
                'model' => Hobby::class,
                'singular' => 'Hobby',
                'plural' => 'Hobbies',
                'icon' => 'bi-palette',
                'table' => 'hobbies',
                'has_parent' => false,
                'with' => [],
            ],
            'incomes' => [
                'type' => 'incomes',
                'model' => Income::class,
                'singular' => 'Income Bracket',
                'plural' => 'Income Brackets',
                'icon' => 'bi-cash-coin',
                'table' => 'incomes',
                'has_parent' => false,
                'with' => [],
            ],
            'marital_statuses' => [
                'type' => 'marital_statuses',
                'model' => MaritalStatus::class,
                'singular' => 'Marital Status',
                'plural' => 'Marital Statuses',
                'icon' => 'bi-heart-half',
                'table' => 'marital_statuses',
                'has_parent' => false,
                'with' => [],
            ],
            'qualifications' => [
                'type' => 'qualifications',
                'model' => Qualification::class,
                'singular' => 'Qualification',
                'plural' => 'Qualifications',
                'icon' => 'bi-mortarboard',
                'table' => 'qualifications',
                'has_parent' => false,
                'with' => [],
            ],
            'working_withs' => [
                'type' => 'working_withs',
                'model' => WorkingWith::class,
                'singular' => 'Working With',
                'plural' => 'Working Withs',
                'icon' => 'bi-briefcase',
                'table' => 'working_withs',
                'has_parent' => false,
                'with' => [],
            ],
        ];

        return $configs[$normalizedType] ?? null;
    }

    /**
     * Render the master CRUD blade view.
     */
    public function index(Request $request, string $type)
    {
        $config = $this->getEntityConfig($type);
        if (!$config) {
            abort(404, 'Master table not found.');
        }

        $parents = [];
        if (!empty($config['has_parent']) && !empty($config['parent_model'])) {
            $parentModel = $config['parent_model'];
            $parents = $parentModel::orderBy('name')->get(['id', 'name']);
        }

        $totalRecords = $config['model']::count();

        return view('admin.masters.index', compact('config', 'parents', 'totalRecords'));
    }

    /**
     * JSON API: Fetch paginated, searchable, filterable master data.
     */
    public function data(Request $request, string $type)
    {
        $config = $this->getEntityConfig($type);
        if (!$config) {
            return response()->json(['success' => false, 'message' => 'Invalid master entity type.'], 404);
        }

        $query = $config['model']::query();

        if (!empty($config['with'])) {
            $query->with($config['with']);
        }

        // Live Search Filter
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search, $config) {
                $q->where('name', 'LIKE', "%{$search}%");

                if (!empty($config['has_parent']) && !empty($config['parent_relation'])) {
                    $q->orWhereHas($config['parent_relation'], function ($pq) use ($search) {
                        $pq->where('name', 'LIKE', "%{$search}%");
                    });
                }
            });
        }

        // Parent ID Filter
        if (!empty($config['has_parent']) && $request->filled('parent_id')) {
            $query->where($config['parent_key'], $request->input('parent_id'));
        }

        // Sorting
        $sortBy = $request->input('sort_by', 'id');
        $sortDir = strtolower($request->input('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        if (in_array($sortBy, ['id', 'name', 'created_at'])) {
            $query->orderBy($sortBy, $sortDir);
        } else {
            $query->latest();
        }

        // Pagination
        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, [10, 25, 50, 100])) {
            $perPage = 10;
        }

        $paginator = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $paginator->items(),
            'pagination' => [
                'current_page' => $paginator->currentPage(),
                'per_page' => $paginator->perPage(),
                'total' => $paginator->total(),
                'last_page' => $paginator->lastPage(),
                'from' => $paginator->firstItem() ?? 0,
                'to' => $paginator->lastItem() ?? 0,
            ],
            'config' => [
                'type' => $config['type'],
                'singular' => $config['singular'],
                'plural' => $config['plural'],
                'has_parent' => $config['has_parent'],
                'parent_label' => $config['parent_label'] ?? null,
            ],
        ]);
    }

    /**
     * JSON API: Fetch parent lookup options for dropdowns.
     */
    public function parents(Request $request, string $type)
    {
        $config = $this->getEntityConfig($type);
        if (!$config || empty($config['has_parent']) || empty($config['parent_model'])) {
            return response()->json(['success' => true, 'data' => []]);
        }

        $parentModel = $config['parent_model'];
        $parents = $parentModel::orderBy('name')->get(['id', 'name']);

        return response()->json([
            'success' => true,
            'data' => $parents,
        ]);
    }

    /**
     * JSON API: Store a new master record.
     */
    public function store(Request $request, string $type)
    {
        $config = $this->getEntityConfig($type);
        if (!$config) {
            return response()->json(['success' => false, 'message' => 'Invalid master entity type.'], 404);
        }

        $rules = [
            'name' => 'required|string|max:255',
        ];

        if (!empty($config['has_parent'])) {
            $rules[$config['parent_key']] = 'required|integer|exists:' . (new $config['parent_model'])->getTable() . ',id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Duplicate Check
        $dupQuery = $config['model']::where('name', trim($request->input('name')));
        if (!empty($config['has_parent'])) {
            $dupQuery->where($config['parent_key'], $request->input($config['parent_key']));
        }

        if ($dupQuery->exists()) {
            return response()->json([
                'success' => false,
                'errors' => ['name' => ['A record with this name already exists.']],
                'message' => 'A record with this name already exists.',
            ], 422);
        }

        $attributes = [
            'name' => trim($request->input('name')),
        ];

        if (!empty($config['has_parent'])) {
            $attributes[$config['parent_key']] = $request->input($config['parent_key']);
        }

        $record = $config['model']::create($attributes);

        if (!empty($config['with'])) {
            $record->load($config['with']);
        }

        return response()->json([
            'success' => true,
            'message' => "{$config['singular']} added successfully.",
            'data' => $record,
            'total' => $config['model']::count(),
        ]);
    }

    /**
     * JSON API: Update an existing master record.
     */
    public function update(Request $request, string $type, $id)
    {
        $config = $this->getEntityConfig($type);
        if (!$config) {
            return response()->json(['success' => false, 'message' => 'Invalid master entity type.'], 404);
        }

        $record = $config['model']::find($id);
        if (!$record) {
            return response()->json(['success' => false, 'message' => "{$config['singular']} not found."], 404);
        }

        $rules = [
            'name' => 'required|string|max:255',
        ];

        if (!empty($config['has_parent'])) {
            $rules[$config['parent_key']] = 'required|integer|exists:' . (new $config['parent_model'])->getTable() . ',id';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Duplicate Check (excluding current record)
        $dupQuery = $config['model']::where('name', trim($request->input('name')))->where('id', '!=', $id);
        if (!empty($config['has_parent'])) {
            $dupQuery->where($config['parent_key'], $request->input($config['parent_key']));
        }

        if ($dupQuery->exists()) {
            return response()->json([
                'success' => false,
                'errors' => ['name' => ['Another record with this name already exists.']],
                'message' => 'Another record with this name already exists.',
            ], 422);
        }

        $record->name = trim($request->input('name'));

        if (!empty($config['has_parent'])) {
            $parentKey = $config['parent_key'];
            $record->$parentKey = $request->input($parentKey);
        }

        $record->save();

        if (!empty($config['with'])) {
            $record->load($config['with']);
        }

        return response()->json([
            'success' => true,
            'message' => "{$config['singular']} updated successfully.",
            'data' => $record,
        ]);
    }

    /**
     * JSON API: Delete a master record safely.
     */
    public function destroy(Request $request, string $type, $id)
    {
        $config = $this->getEntityConfig($type);
        if (!$config) {
            return response()->json(['success' => false, 'message' => 'Invalid master entity type.'], 404);
        }

        $record = $config['model']::find($id);
        if (!$record) {
            return response()->json(['success' => false, 'message' => "{$config['singular']} not found."], 404);
        }

        // Cascade protection check: Country has states
        if ($config['type'] === 'countries' && method_exists($record, 'states') && $record->states()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete country: {$record->states()->count()} states are linked to it.",
            ], 422);
        }

        // Cascade protection check: State has cities
        if ($config['type'] === 'states' && method_exists($record, 'cities') && $record->cities()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete state: {$record->cities()->count()} cities are linked to it.",
            ], 422);
        }

        // Cascade protection check: Religion has communities
        if ($config['type'] === 'religions' && method_exists($record, 'communities') && $record->communities()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => "Cannot delete religion: {$record->communities()->count()} communities are linked to it.",
            ], 422);
        }

        $record->delete();

        return response()->json([
            'success' => true,
            'message' => "{$config['singular']} deleted successfully.",
            'total' => $config['model']::count(),
        ]);
    }
}
