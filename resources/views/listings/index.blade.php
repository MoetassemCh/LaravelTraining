{{-- @extends('layout')

@section('content') --}}
<x-layout>
@include('partials._hero')
@include('partials._search')
 <div class="bg-gray-50 border border-gray-200 rounded p-6">
    @unless(count($listings)==0)
    @foreach ($listings as $listing)
   <x-listing-card :listing="$listing" />
    @endforeach
    @else
        <p>No listings found</p>
    @endunless
</div>
<div class="mt-6 p-4">
    {{$listings->links()}}
</div>
</x-layout>
{{-- @endsection --}}