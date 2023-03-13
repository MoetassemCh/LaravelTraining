<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    //Show all listings
    public function index()
    {
        // dd($request);

    return view('listings.index', [
        'listings' => Listing::latest()->filter(request(['tag','search']))->simplePaginate(5)
    ]);    }

    //Show a single listing
    public function show(Listing $listing){
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    //Create a new listing
    public function create(){
        return view('listings.create');
    }

    //Store a new listing
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required',Rule::unique('listings','company')],
            'location' => 'required',
            'website' => 'required',
            'email'=>['required','email'],
            'tags' => 'required',
            'description' => 'required',
        ]);
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos','public');
        }

        // $listing->user_id = auth()->id();
        // $listing->save();
        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        return redirect('/')->with('message','Listing Created Successfully!');
    }

    //Show Edit Form

    public function edit(Listing $listing){
        return view('listings.edit',[
            'listing'=>$listing
        ]);
    }

    //Update Listing
    public function update(Request $request,Listing $listing)
    {
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required',
        ]);
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // $listing->user_id = auth()->id();
        // $listing->save();
        $listing->update($formFields);

        return back()->with('message', 'Listing Updated Successfully!');
    }

    //Delete Listing
    public function delete(Listing $listing){
        if ($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        if ($listing->logo && Storage::disk('public')->exists($listing->logo)) {
            Storage::disk('public')->delete($listing->logo);
        }
        $listing->delete();
        return redirect('/')->with('message','Listing Deleted Successfully!');
    }

    //Manage Listings
    public function manage() {
        return view('listings.manage', ['listings' => request()->user()->listings()->get()]);
    }

}
