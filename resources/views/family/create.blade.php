@extends('layouts.app')

@section('title', 'Create Family')

@section('content')

<div class="container py-4">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Create Family</h4>
        </div>

        <div class="card-body">

            <form id="familyForm"
                  action="{{ route('family.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- FAMILY HEAD --}}
                <h5 class="mb-3 text-primary">
                    Family Head Details
                </h5>

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Name <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Surname --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Surname <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="surname"
                               id="surname"
                               value="{{ old('surname') }}"
                               class="form-control @error('surname') is-invalid @enderror">

                        @error('surname')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Birthdate --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Birthdate <span class="text-danger">*</span>
                        </label>

                        <input type="date"
                               name="birthdate"
                               id="birthdate"
                               value="{{ old('birthdate') }}"
                               class="form-control @error('birthdate') is-invalid @enderror">

                        @error('birthdate')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Mobile --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Mobile Number <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="mobile_no"
                               id="mobile_no"
                               value="{{ old('mobile_no') }}"
                               class="form-control @error('mobile_no') is-invalid @enderror">

                        @error('mobile_no')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Address --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Address <span class="text-danger">*</span>
                        </label>

                        <textarea name="address"
                                  id="address"
                                  rows="3"
                                  class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- State --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            State <span class="text-danger">*</span>
                        </label>

                        <select name="state"
                                id="state"
                                class="form-select @error('state') is-invalid @enderror">

                            <option value="">
                                Select State
                            </option>

                            @foreach($states as $state)

                                <option value="{{ $state }}"
                                    {{ old('state') == $state ? 'selected' : '' }}>

                                    {{ $state }}

                                </option>

                            @endforeach

                        </select>

                        @error('state')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- City --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            City <span class="text-danger">*</span>
                        </label>

                        <select name="city"
                                id="city"
                                class="form-select @error('city') is-invalid @enderror">

                            <option value="">
                                Select City
                            </option>

                        </select>

                        @error('city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Pincode --}}
                    <div class="col-md-4 mb-3">

                        <label class="form-label">
                            Pincode <span class="text-danger">*</span>
                        </label>

                        <input type="text"
                               name="pincode"
                               id="pincode"
                               value="{{ old('pincode') }}"
                               class="form-control @error('pincode') is-invalid @enderror">

                        @error('pincode')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Marital Status --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Marital Status <span class="text-danger">*</span>
                        </label>

                        <select name="marital_status"
                                id="marital_status"
                                class="form-select @error('marital_status') is-invalid @enderror">

                            <option value="">Select Status</option>

                            <option value="married"
                                {{ old('marital_status') == 'married' ? 'selected' : '' }}>
                                Married
                            </option>

                            <option value="unmarried"
                                {{ old('marital_status') == 'unmarried' ? 'selected' : '' }}>
                                Unmarried
                            </option>

                        </select>

                        @error('marital_status')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Wedding Date --}}
                    <div class="col-md-6 mb-3"
                         id="weddingDateDiv"
                         style="display:none;">

                        <label class="form-label">
                            Wedding Date
                        </label>

                        <input type="date"
                               name="wedding_date"
                               id="wedding_date"
                               value="{{ old('wedding_date') }}"
                               class="form-control @error('wedding_date') is-invalid @enderror">

                        @error('wedding_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Photo --}}
                    <div class="col-md-12 mb-3">

                        <label class="form-label">
                            Photo
                        </label>

                        <input type="file"
                               name="photo"
                               id="photo"
                               class="form-control @error('photo') is-invalid @enderror">

                        @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </div>



                {{-- HOBBIES --}}
                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="text-primary mb-0">
                        Hobbies
                    </h5>

                    <button type="button"
                            class="btn btn-success btn-sm"
                            id="addHobbyBtn">

                        Add Hobby

                    </button>

                </div>

                <div id="hobbiesContainer">

                    @if(old('hobbies'))
                            {{ Log::info('Old Hobbies: ', old('hobbies')) }}
                        @foreach(old('hobbies', []) as $i => $hobby)
                            <div class="row hobby-row">
                                <div class="col-md-10 mb-2">
                                    <input type="text"
                                        name="hobbies[{{ $i }}][name]"
                                        value="{{ $hobby['name'] ?? $hobby }}"
                                        class="form-control hobby-input"
                                        placeholder="Enter Hobby">
                                </div>
                                <div class="col-md-2 mb-2">
                                    <button type="button" class="btn btn-danger removeHobbyBtn">Remove</button>
                                </div>
                            </div>
                        @endforeach

                    @else

                        <div class="row hobby-row">

                            <div class="col-md-10 mb-2">

                                <input type="text"
                                    name="hobbies[0][name]"
                                    class="form-control hobby-input"
                                    placeholder="Enter Hobby">

                            </div>

                            <div class="col-md-2 mb-2">

                                <button type="button"
                                        class="btn btn-danger removeHobbyBtn">

                                    Remove

                                </button>

                            </div>

                        </div>

                    @endif

                </div>



                {{-- FAMILY MEMBERS --}}
                <hr>

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="text-primary mb-0">
                        Family Members
                    </h5>

                    <button type="button"
                            class="btn btn-primary btn-sm"
                            id="addMemberBtn">

                        Add Member

                    </button>

                </div>

                <div id="membersContainer">

                    @if(old('members'))

                        @foreach(old('members') as $index => $member)

                            <div class="card border mb-3 member-card">

                                <div class="card-body">

                                    <div class="d-flex justify-content-between mb-3">

                                        <h5>Member</h5>

                                        <button type="button"
                                                class="btn btn-danger btn-sm removeMemberBtn">

                                            Remove

                                        </button>

                                    </div>

                                    <div class="row">

                                        <div class="col-md-6 mb-3">

                                            <label>Name</label>

                                            <input type="text"
                                                name="members[{{ $index }}][name]"
                                                value="{{ $member['name'] ?? '' }}"
                                                class="form-control member-name">

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label>Birthdate</label>

                                            <input type="date"
                                                name="members[{{ $index }}][birthdate]"
                                                value="{{ $member['birthdate'] ?? '' }}"
                                                class="form-control member-birthdate">

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label>Marital Status</label>

                                            <select name="members[{{ $index }}][marital_status]"
                                                    class="form-select member-marital-status">

                                                <option value="">Select</option>

                                                <option value="married"
                                                    {{ ($member['marital_status'] ?? '') == 'married' ? 'selected' : '' }}>
                                                    Married
                                                </option>

                                                <option value="unmarried"
                                                    {{ ($member['marital_status'] ?? '') == 'unmarried' ? 'selected' : '' }}>
                                                    Unmarried
                                                </option>

                                            </select>

                                        </div>


                                        <div class="col-md-6 mb-3 member-wedding-div"
                                            style="{{ ($member['marital_status'] ?? '') == 'married' ? '' : 'display:none;' }}">

                                            <label>Wedding Date</label>

                                            <input type="date"
                                                name="members[{{ $index }}][wedding_date]"
                                                value="{{ $member['wedding_date'] ?? '' }}"
                                                class="form-control member-wedding-date">

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label>Education</label>

                                            <input type="text"
                                                name="members[{{ $index }}][education]"
                                                value="{{ $member['education'] ?? '' }}"
                                                class="form-control member-education">

                                        </div>


                                        <div class="col-md-6 mb-3">

                                            <label>Photo</label>

                                            <input type="file"
                                                name="members[{{ $index }}][photo]"
                                                class="form-control member-photo">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    @endif

                </div>



                {{-- Submit --}}
                <div class="mt-4">

                    <button type="submit"
                            class="btn btn-success px-4">

                        Submit

                    </button>
                    <a href="{{ route('family.index') }}"
                       class="btn btn-secondary ms-2">

                        Cancel
                    </a>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection



@section('scripts')

<script>

$(document).ready(function () {

    toggleWeddingDate();

    @if(old('marital_status') == 'married')
        $('#weddingDateDiv').show();
    @endif

    $('#marital_status').change(function () {
        toggleWeddingDate();
    });



    function toggleWeddingDate()
    {
        if ($('#marital_status').val() == 'married') {

            $('#weddingDateDiv').show();

        } else {

            $('#weddingDateDiv').hide();

            $('#wedding_date').val('');
        }
    }



    /*
    |--------------------------------------------------------------------------
    | ADD HOBBY
    |--------------------------------------------------------------------------
    */

    $('#addHobbyBtn').click(function () {

        let hobbyIndex = {{ old('hobbies') ? count(old('hobbies')) : 1 }};

        $('#hobbiesContainer').append(`

            <div class="row hobby-row">

                <div class="col-md-10 mb-2">

                    <input type="text"
                           name="hobbies[${hobbyIndex}][name]"
                           class="form-control hobby-input"
                           placeholder="Enter Hobby">

                </div>

                <div class="col-md-2 mb-2">

                    <button type="button"
                            class="btn btn-danger removeHobbyBtn">

                        Remove

                    </button>

                </div>

            </div>

        `);
        hobbyIndex++;
    });



    $(document).on('click', '.removeHobbyBtn', function () {

        $(this).closest('.hobby-row').remove();

    });




    /*
    |--------------------------------------------------------------------------
    | ADD FAMILY MEMBER
    |--------------------------------------------------------------------------
    */

    let memberIndex = {{ old('members') ? count(old('members')) : 0 }};

    $('#addMemberBtn').click(function () {

        let memberHtml = `

            <div class="card border mb-3 member-card">

                <div class="card-body">

                    <div class="d-flex justify-content-between mb-3">

                        <h5>Member</h5>

                        <button type="button"
                                class="btn btn-danger btn-sm removeMemberBtn">

                            Remove

                        </button>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Name</label>

                            <input type="text"
                                   name="members[${memberIndex}][name]"
                                   class="form-control member-name">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label>Birthdate</label>

                            <input type="date"
                                   name="members[${memberIndex}][birthdate]"
                                   class="form-control member-birthdate">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label>Marital Status</label>

                            <select name="members[${memberIndex}][marital_status]"
                                    class="form-select member-marital-status">

                                <option value="">Select</option>

                                <option value="married">Married</option>

                                <option value="unmarried">Unmarried</option>

                            </select>

                        </div>


                        <div class="col-md-6 mb-3 member-wedding-div"
                             style="display:none;">

                            <label>Wedding Date</label>

                            <input type="date"
                                   name="members[${memberIndex}][wedding_date]"
                                   class="form-control member-wedding-date">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label>Education</label>

                            <input type="text"
                                   name="members[${memberIndex}][education]"
                                   class="form-control member-education">

                        </div>


                        <div class="col-md-6 mb-3">

                            <label>Photo</label>

                            <input type="file"
                                   name="members[${memberIndex}][photo]"
                                   class="form-control member-photo">

                        </div>

                    </div>

                </div>

            </div>

        `;

        $('#membersContainer').append(memberHtml);

        memberIndex++;

    });




    /*
    |--------------------------------------------------------------------------
    | MEMBER MARITAL STATUS
    |--------------------------------------------------------------------------
    */

    $(document).on('change', '.member-marital-status', function () {

        let value = $(this).val();

        let weddingDiv = $(this)
                            .closest('.row')
                            .find('.member-wedding-div');

        if (value == 'married') {

            weddingDiv.show();

        } else {

            weddingDiv.hide();

            weddingDiv.find('input').val('');
        }

    });




    /*
    |--------------------------------------------------------------------------
    | REMOVE MEMBER
    |--------------------------------------------------------------------------
    */

    $(document).on('click', '.removeMemberBtn', function () {

        $(this).closest('.member-card').remove();

    });




    /*
    |--------------------------------------------------------------------------
    | CLIENT SIDE VALIDATION
    |--------------------------------------------------------------------------
    */

    $('#familyForm').submit(function (e) {

        $('.client-error').remove();

        let isValid = true;



        function showError(element, message)
        {
            element.after(`
                <small class="text-danger client-error">
                    ${message}
                </small>
            `);

            isValid = false;
        }



        // Name
        if ($('#name').val().trim() == '') {

            showError($('#name'), 'Name is required');
        }



        // Surname
        if ($('#surname').val().trim() == '') {

            showError($('#surname'), 'Surname is required');
        }



        // Birthdate
        let birthdate = $('#birthdate').val();

        if (birthdate == '') {

            showError($('#birthdate'), 'Birthdate is required');

        } else {

            let dob = new Date(birthdate);

            let today = new Date();

            let age = today.getFullYear() - dob.getFullYear();

            if (age < 21) {

                showError($('#birthdate'),
                    'Age must be above 21 years');
            }
        }



        // Mobile
        let mobile = $('#mobile_no').val();

        if (mobile == '') {

            showError($('#mobile_no'),
                'Mobile number is required');

        } else if (!/^[0-9]{10,13}$/.test(mobile)) {

            showError($('#mobile_no'),
                'Mobile number must be 10 to 13 digits');
        }



        // Address
        if ($('#address').val().trim() == '') {

            showError($('#address'),
                'Address is required');
        }



        // State
        if ($('#state').val().trim() == '') {

            showError($('#state'),
                'State is required');
        }



        // City
        if ($('#city').val().trim() == '') {

            showError($('#city'),
                'City is required');
        }



        // Pincode
        let pincode = $('#pincode').val();

        if (pincode == '') {

            showError($('#pincode'),
                'Pincode is required');

        } else if (!/^[0-9]{6}$/.test(pincode)) {

            showError($('#pincode'),
                'Pincode must be 6 digits');
        }



        // Marital Status
        if ($('#marital_status').val() == '') {

            showError($('#marital_status'),
                'Marital status is required');
        }



        // Wedding Date
        if ($('#marital_status').val() == 'married'
            && $('#wedding_date').val() == '') {

            showError($('#wedding_date'),
                'Wedding date is required');
        }



        // Photo Validation
        let photo = $('#photo')[0].files[0];

        if (photo) {

            let allowed = [
                'image/jpeg',
                'image/png',
                'image/jpg',
                'image/webp'
            ];

            if (!allowed.includes(photo.type)) {

                showError($('#photo'),
                    'Only jpeg, png, jpg, webp allowed');
            }

            if (photo.size > 2 * 1024 * 1024) {

                showError($('#photo'),
                    'Photo size must be less than 2MB');
            }
        }



        /*
        |--------------------------------------------------------------------------
        | HOBBIES VALIDATION
        |--------------------------------------------------------------------------
        */

        $('.hobby-input').each(function () {

            if ($(this).val().trim() == '') {

                showError($(this),
                    'Hobby is required');
            }

        });




        /*
        |--------------------------------------------------------------------------
        | MEMBER VALIDATION
        |--------------------------------------------------------------------------
        */

        $('.member-card').each(function () {

            let name = $(this).find('.member-name');

            let birthdate = $(this).find('.member-birthdate');

            let marital = $(this).find('.member-marital-status');

            let wedding = $(this).find('.member-wedding-date');

            let education = $(this).find('.member-education');

            let photo = $(this).find('.member-photo')[0].files[0];



            if (name.val().trim() == '') {

                showError(name,
                    'Member name is required');
            }



            if (birthdate.val() == '') {

                showError(birthdate,
                    'Birthdate is required');
            }



            if (marital.val() == '') {

                showError(marital,
                    'Marital status is required');
            }



            if (marital.val() == 'married'
                && wedding.val() == '') {

                showError(wedding,
                    'Wedding date is required');
            }



            if (education.val().trim() == '') {

                showError(education,
                    'Education is required');
            }



            if (photo) {

                let allowed = [
                    'image/jpeg',
                    'image/png',
                    'image/jpg',
                    'image/webp'
                ];

                if (!allowed.includes(photo.type)) {

                    showError($(this).find('.member-photo'),
                        'Invalid image type');
                }

                if (photo.size > 2 * 1024 * 1024) {

                    showError($(this).find('.member-photo'),
                        'Image must be less than 2MB');
                }
            }

        });




        if (!isValid) {

            e.preventDefault();
        }
    });

    $('#state').change(function () {

        loadCities();

    });

    @if(old('state'))

        loadCities("{{ old('city') }}");

    @endif

    function loadCities(selectedCity = '')
    {
        let state = $('#state').val();

        $('#city').html('<option value="">Loading...</option>');

        if (state != '') {

            $.ajax({

                url: "{{ route('family.getCities') }}",

                type: "GET",

                data: {
                    state: state
                },

                success: function (response) {

                    let options = '<option value="">Select City</option>';

                    $.each(response, function (key, city) {

                        let selected = selectedCity == city
                            ? 'selected'
                            : '';

                        options += `
                            <option value="${city}" ${selected}>
                                ${city}
                            </option>
                        `;
                    });

                    $('#city').html(options);
                }

            });

        } else {

            $('#city').html(
                '<option value="">Select City</option>'
            );
        }
    }

});

</script>

@endsection