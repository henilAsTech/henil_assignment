<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFamilyRequest;
use App\Models\FamilyHead;
use App\Services\FamilyService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FamilyController extends Controller
{
    private array $states = [
        'Delhi', 'Gujarat', 'Karnataka', 'Kerala', 'Madhya Pradesh', 
        'Maharashtra', 'Rajasthan',  'Tamil Nadu', 'Uttar Pradesh', 'West Bengal',  
    ];

    public function __construct(
        private readonly FamilyService $familyService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->familyService->getAll();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('age', function ($row) {
                    return $row->age ?? 'N/A';
                })
                ->addColumn('family_head', function ($row) {
                    return $row->familyHead->name ?? 'N/A';
                })
                ->addColumn('photo', function ($row) {
                    $image = $row->photoUrl ?? asset('images/default.webp');

                    return '<img src="' . $image . '" width="50" height="50" class="rounded-circle">';
                })
                ->addColumn('members_count', function ($row) {
                    return '
                        <button class="btn btn-info btn-sm"
                                onclick="showFamilyDetails(' . $row->id . ')">
                            ' . $row->family_members_count . '
                        </button>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <a href="' . route('family.edit', $row->id) . '"
                           class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <a href="' . route('family.show', $row->id) . '"
                           class="btn btn-success btn-sm">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        <form action="' . route('family.destroy', $row->id) . '"
                              method="POST"
                              style="display:inline-block;"
                              onsubmit="return confirm(\'Are you sure you want to delete this family?\')">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>';
                })
                ->rawColumns(['photo', 'members_count', 'action'])
                ->make(true);
        }

        return view('family.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('family.create', [
            'states'        => $this->states,
            'citiesByState' => $this->familyService->getCitiesByState(''),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFamilyRequest $request)
    {
        try {
            $this->familyService->createFamily($request->validated(), $request);

            return redirect()
                ->route('family.index')
                ->with('success', 'Family record created successfully!');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FamilyHead $family)
    {
        $family = $this->familyService->find($family->id);
        return view('family.show', compact('family'));
    }

    public function familyDetails(FamilyHead $family)
    {
        $family = $this->familyService->find($family->id);
        return response()->json([
            'family' => $family,
            'hobbies' => $family->hobbies,
            'members' => $family->familyMembers,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FamilyHead $family)
    {
        $family = $this->familyService->find($family->id);

        return view('family.edit', [
            'family'        => $family,
            'states'        => $this->states,
            'citiesByState' => $this->familyService->getCitiesByState($family->state ?? ''),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreFamilyRequest $request, FamilyHead $family)
    {
        try {
            $this->familyService->updateFamily($family->id, $request->validated(), $request);

            return redirect()
                ->route('family.index')
                ->with('success', 'Family updated successfully.');

        } catch (\Throwable $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FamilyHead $family)
    {
        try {
            $family->load('familyMembers');
            $this->familyService->deleteFamily($family);

            return redirect()
                ->route('family.index')
                ->with('success', 'Family deleted successfully.');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Return city list for a given state (AJAX).
     */
    public function getCities(Request $request)
    {
        $cities = $this->familyService->getCitiesByState(
            $request->get('state', '')
        );

        return response()->json($cities);
    }
}