@extends('layouts.app')

@section('title', 'Family Details')

@section('content')

<div class="container py-4">

    {{-- Page Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="mb-0 text-primary">
            Family Details
        </h3>

        <a href="{{ route('family.index') }}"
           class="btn btn-secondary">

            Back

        </a>

    </div>



    {{-- Family Head Details --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                Family Head Information
            </h5>

        </div>

        <div class="card-body">

            <div class="row">

                {{-- Photo --}}
                <div class="col-md-3 text-center mb-3">

                    @if($family->photo)

                        <img src="{{ $family->photoUrl }}"
                             class="rounded-circle shadow"
                             width="180">

                    @else

                        <img src="{{ asset('images/default.webp') }}"
                             class="rounded-circle shadow"
                             width="180">

                    @endif

                </div>



                {{-- Details --}}
                <div class="col-md-9">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <strong>Name:</strong><br>

                            {{ $family->name }}

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Surname:</strong><br>

                            {{ $family->surname }}

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Birthdate:</strong><br>

                            {{ \Carbon\Carbon::parse($family->birthdate)->format('d M Y') }}

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Mobile Number:</strong><br>

                            {{ $family->mobile_no }}

                        </div>


                        <div class="col-md-12 mb-3">

                            <strong>Address:</strong><br>

                            {{ $family->address }}

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>State:</strong><br>

                            {{ $family->state }}

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>City:</strong><br>

                            {{ $family->city }}

                        </div>


                        <div class="col-md-4 mb-3">

                            <strong>Pincode:</strong><br>

                            {{ $family->pincode }}

                        </div>


                        <div class="col-md-6 mb-3">

                            <strong>Marital Status:</strong><br>

                            <span class="badge bg-{{ $family->marital_status == 'married' ? 'success' : 'secondary' }}">

                                {{ ucfirst($family->marital_status) }}

                            </span>

                        </div>


                        @if($family->marital_status == 'married')

                            <div class="col-md-6 mb-3">

                                <strong>Wedding Date:</strong><br>

                                {{ \Carbon\Carbon::parse($family->wedding_date)->format('d M Y') }}

                            </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>




    {{-- Hobbies --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-header bg-success text-white">

            <h5 class="mb-0">
                Hobbies
            </h5>

        </div>

        <div class="card-body">

            @if($family->hobbies->count())

                <div class="d-flex flex-wrap gap-2">

                    @foreach($family->hobbies as $hobby)

                        <span class="badge bg-success p-2">

                            {{ $hobby->hobby_name }}

                        </span>

                    @endforeach

                </div>

            @else

                <p class="text-muted mb-0">

                    No hobbies added.

                </p>

            @endif

        </div>

    </div>




    {{-- Family Members --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-info text-white">

            <h5 class="mb-0">
                Family Members
                ({{ $family->familyMembers->count() }})
            </h5>

        </div>

        <div class="card-body">

            @if($family->familyMembers->count())

                <div class="row">

                    @foreach($family->familyMembers as $member)

                        <div class="col-md-6 mb-4">

                            <div class="card border h-100">

                                <div class="card-body">

                                    <div class="text-center mb-3">

                                        @if($member->photo)

                                            <img src="{{ asset('storage/'.$member->photo) }}"
                                                 class="rounded-circle shadow"
                                                 width="100"
                                                 height="100">

                                        @else

                                            <img src="{{ asset('images/default.webp') }}"
                                                class="rounded-circle shadow"
                                                width="100"
                                                height="100">

                                        @endif

                                    </div>



                                    <div class="mb-2">

                                        <strong>Name:</strong>

                                        {{ $member->name }}

                                    </div>


                                    <div class="mb-2">

                                        <strong>Birthdate:</strong>

                                        {{ \Carbon\Carbon::parse($member->birthdate)->format('d M Y') }}

                                    </div>


                                    <div class="mb-2">

                                        <strong>Marital Status:</strong>

                                        <span class="badge bg-{{ $member->marital_status == 'married' ? 'success' : 'secondary' }}">

                                            {{ ucfirst($member->marital_status) }}

                                        </span>

                                    </div>


                                    @if($member->marital_status == 'married')

                                        <div class="mb-2">

                                            <strong>Wedding Date:</strong>

                                            {{ \Carbon\Carbon::parse($member->wedding_date)->format('d M Y') }}

                                        </div>

                                    @endif


                                    <div class="mb-2">

                                        <strong>Education:</strong>

                                        {{ $member->education }}

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <p class="text-muted mb-0">

                    No family members added.

                </p>

            @endif

        </div>

    </div>

</div>

@endsection