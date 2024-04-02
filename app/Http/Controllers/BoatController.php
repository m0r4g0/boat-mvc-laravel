<?php

namespace App\Http\Controllers;

use App\Models\Boat;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BoatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $boats = Boat::all();
        return view('boats.index', compact('boats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('boats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
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
                    // If the exact slug exists, find the maximum appended number
                    $maxAppendedNumber = Boat::where('slug', 'like', $slug . '-%')
                        ->get()
                        ->map(fn ($boat) => intval(str_replace($slug . '-', '', (string) $boat->slug)))
                        ->max();

                    // Increment the maximum number by 1 to generate the new slug
                    $slug = $slug . '-' . ($maxAppendedNumber + 1);
                }
                $user_id = auth()->id();
                // Create the boat
                Boat::create([
                    'name' => $request->name,
                    'category' => $request->category,
                    'slug' => $slug,
                    'user_id' => $user_id,
                ]);
            });
            return redirect()->route('boats.index')->with('success', 'Boat created successfully.');
        } catch (QueryException) {
            // Handle the error when the database is locked
            return redirect()->back()->with('error', 'Error: The boat creation process failed due to a database lock.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $idOrSlug): View
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
    public function edit(Boat $boat): View|RedirectResponse
    {
        // Check if the authenticated user is the owner of the boat
        if (auth()->user()->id !== $boat->user_id) {
            // Unauthorized user, redirect back or show an error message
            return redirect()->route('boats.index')->withErrors([
                'error' => 'You are not authorized to edit this boat.',
            ]);
        }

        return view('boats.edit', compact('boat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boat $boat): RedirectResponse
    {
        // Check if the authenticated user is the owner of the boat
        if (auth()->user()->id !== $boat->user_id) {
            // Unauthorized user, redirect back or show an error message
            return redirect()->route('boats.index')->withErrors([
                'error' => 'You are not authorized to edit this boat.',
            ]);
        }

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
    public function destroy(Boat $boat): RedirectResponse
    {
        // Check if the authenticated user is the owner of the boat
        if (auth()->user()->id !== $boat->user_id) {
            // Unauthorized user, redirect back or show an error message
            return redirect()->route('boats.index')->withErrors([
                'error' => 'You are not authorized to edit this boat.',
            ]);
        }

        $boat->delete();
        return redirect()->route('boats.index')->with('success', 'Boat deleted successfully.');
    }
}
