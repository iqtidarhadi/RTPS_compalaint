<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\Village;
use App\Models\Backend\UnionCouncil;
use App\Models\Backend\Tehsil;
use App\Models\Backend\District;
use App\Models\Backend\Province;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Routing\Controllers\HasMiddleware;

class VillageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:village-list|village-create|village-edit|village-delete', only: ['index', 'store']),
            new Middleware('permission:village-create', only: ['create', 'store']),
            new Middleware('permission:village-edit', only: ['edit', 'update']),
            new Middleware('permission:village-delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() && $request->isMethod('post')) {
            $modelData = Village::with(['unionCouncil.tehsil.district.province'])->orderBy('id', 'desc');
            return Datatables::of($modelData)
                ->addIndexColumn()
                ->addColumn('union_council_title', function ($row) {
                    return $row?->union_council ? $row?->union_council?->title : 'N/A';
                })
                ->addColumn('tehsil_title', function ($row) {
                    return $row?->tehsil ? $row?->tehsil?->title : 'N/A';
                })
                ->addColumn('district_title', function ($row) {
                    return $row?->district ? $row?->district?->title : 'N/A';
                })
                ->addColumn('province_title', function ($row) {
                    return $row?->district && $row?->district?->province ? $row?->district?->province?->title : 'N/A';
                })
                ->addColumn('status', function ($row) {
                    return $row->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('action', function ($row) {
                    return customButtonCrypt($row, 'village', 'app.villages', false);
                })
                ->rawColumns(['action', 'status'])
                ->toJson();
        }

        $data = [
            'title' => 'Villages Listings',
        ];
        return view('app.villages.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Create Village',
            'isEdit' => false,
            'model' => null,
            'provinces' => Province::where('active', 1)->pluck('title', 'id')->all(),
        ];
        return view('app.villages.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => ['required', 'string', 'max:125'],
                'union_council_id' => ['required', 'integer', 'exists:union_councils,id'],
                'ur_title' => ['nullable', 'string', 'max:125'],
                'short_title' => ['nullable', 'string', 'max:50'],
                'active' => ['required', 'boolean'],
                'description' => ['nullable', 'string'],
            ]);

            Village::create($validatedData);

            return redirect()->route('app.villages.index')->with('success', 'Village created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error creating village: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $village = Village::with(['unionCouncil.tehsil.district.province'])->findOrFail(decrypt($id));
            $data = [
                'title' => 'Edit Village',
                'isEdit' => true,
                'model' => $village,
                'provinces' => Province::where('active', 1)->pluck('title', 'id')->all(),
                'districts' => District::where('province_id', $village->unionCouncil->tehsil->district->province_id ?? null)
                    ->where('active', 1)->pluck('title', 'id')->all(),
                'tehsils' => Tehsil::where('district_id', $village->unionCouncil->tehsil->district_id ?? null)
                    ->where('active', 1)->pluck('title', 'id')->all(),
                'unionCouncils' => UnionCouncil::where('tehsil_id', $village->unionCouncil->tehsil_id ?? null)
                    ->where('active', 1)->pluck('title', 'id')->all(),
            ];
            return view('app.villages.form', $data);
        } catch (\Exception $e) {
            return redirect()->route('app.villages.index')->with('error', 'Village not found.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $village = Village::findOrFail(decrypt($id));
            
            $validatedData = $request->validate([
                'title' => ['required', 'string', 'max:125'],
                'union_council_id' => ['required', 'integer', 'exists:union_councils,id'],
                'ur_title' => ['nullable', 'string', 'max:125'],
                'short_title' => ['nullable', 'string', 'max:50'],
                'active' => ['required', 'boolean'],
                'description' => ['nullable', 'string'],
            ]);

            $village->update($validatedData);

            return redirect()->route('app.villages.index')->with('success', 'Village updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error updating village: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $village = Village::findOrFail(decrypt($id));
            $village->delete();
            
            return redirect()->route('app.villages.index')->with('success', 'Village deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting village: ' . $e->getMessage());
        }
    }
}
