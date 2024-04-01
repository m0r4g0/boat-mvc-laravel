<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;


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
        // Add the slug to the request data for validation
        $slug = Str::slug($request->name);
        $request->merge(['slug' => $slug]);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'category' => ['required', Rule::in(['sailing-yacht', 'motor-boat'])]
        ]);
      

        // Add the custom validation rule for the slug field
        $validator->sometimes('slug', [function ($attribute, $value, $fail) use ($slug) {
            // Check if the slug already exists in the database
            if (Boat::where('slug', $slug)->exists()) {
                // Throw a validation error if the slug already exists
                $fail('The '.$attribute.' must be unique based on the name.');
            }
        }], function ($input) {
            // Only apply the custom validation rule if the 'slug' field is present in the request
            return isset($input['slug']);
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If the slug already exists, validation will fail
        // No need for manual check
        $boat = new Boat();
        $boat->name = $request->name;
        $boat->category = $request->category;
        $boat->slug = $slug;
        $boat->save();
    
        return redirect()->route('boats.index')->with('success', 'Boat created successfully.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('boats.edit', compact('boat'));
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
