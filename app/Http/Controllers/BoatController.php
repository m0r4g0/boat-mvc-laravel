<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;



class BoatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $boats = Boat::all();
        return view('boats.index', compact('boats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('boats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => ['required', Rule::in(['sailing-yacht', 'motor-boat'])],
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Generate the slug from the provided name
        $slug = Str::slug($request->name);
    
        // Use database transaction with locking to ensure atomicity and prevent race conditions
        DB::transaction(function () use ($request, $slug) {
            // Lock the boats table to prevent other users from accessing it until the transaction is complete
            Boat::lockForUpdate()->get();
    
            // Check if the slug already exists in the database
            $existingBoat = Boat::where('slug', $slug)->first();

            if ($existingBoat) {
                // If the exact slug exists, generate a new slug with an incremental number
                $count = Boat::where('slug', 'like', $slug . '-%')->count();
                $slug = $slug . '-' . ($count + 1);
            }
    
            // Create the boat
            Boat::create([
                'name' => $request->name,
                'category' => $request->category,
                'slug' => $slug,
            ]);
        });
    
        return redirect()->route('boats.index')->with('success', 'Boat created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $idOrSlug)
{
    // Check if the parameter is numeric (ID) or a string (slug)
    if (ctype_digit($idOrSlug)) {
        // Parameter is numeric (ID)
        $boat = Boat::findOrFail($idOrSlug);
    } else {
        // Parameter is a string (slug)
        $boat = Boat::where('slug', $idOrSlug)->firstOrFail();
    }
    
    return view('boats.show', compact('boat'));
}
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Boat $boat)
    {
        return view('boats.edit', compact('boat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boat $boat)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => ['required', Rule::in(['sailing-yacht', 'motor-boat'])],
        ]);

        $boat->name = $request->name;
        $boat->category = $request->category;
        $boat->save();

        return redirect()->route('boats.index')->with('success', 'Boat updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boat $boat)
    {
        $boat->delete();
        return redirect()->route('boats.index')->with('success', 'Boat deleted successfully.');
    }
}
