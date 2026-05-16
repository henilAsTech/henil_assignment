@extends('layouts.app')

@section('title', 'Family Head List')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Family Head List</h3>

        <a href="{{ route('family.create') }}" class="btn btn-primary">
            Add Family
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered yajra-datatable w-100">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Age</th>
                        <th>Mobile</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Members Count</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

</div>

{{-- Family Details Modal --}}
<div class="modal fade" id="familyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Family Details</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="familyDetailsBody">

            </div>

        </div>
    </div>
</div>

@endsection


@section('scripts')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>

$(function () {

    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('family.index') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            
            {
                data: 'photo',
                name: 'photo',
                orderable: false,
                searchable: false
            },

            {
                data: 'name',
                name: 'name'
            },

            {
                data: 'surname',
                name: 'surname'
            },

            {
                data: 'age',
                name: 'age'
            },

            {
                data: 'mobile_no',
                name: 'mobile_no'
            },

            {
                data: 'state',
                name: 'state'
            },

            {
                data: 'city',
                name: 'city'
            },

            {
                data: 'members_count',
                name: 'family_members_count',
                orderable: false,
                searchable: false
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

});



function showFamilyDetails(id)
{
    $.ajax({

        url: "{{ route('family.details', ':id') }}".replace(':id', id),

        type: "GET",

        success: function(response)
        {
            let html = '';
            
            console.log(response.family.full_name);
            
            html += `
                <div class="row mb-4">

                    <div class="col-md-3">
                        <img src="${response.family.photo_url}" 
                             class="img-fluid rounded border">
                    </div>

                    <div class="col-md-9">

                        <h4>${response.family.full_name}</h4>

                        <p>
                            <strong>Mobile:</strong> ${response.family.mobile_no}
                        </p>

                        <p>
                            <strong>Address:</strong> ${response.family.address}
                        </p>

                        <p>
                            <strong>State:</strong> ${response.family.state}
                        </p>

                        <p>
                            <strong>City:</strong> ${response.family.city}
                        </p>

                        <p>
                            <strong>Pincode:</strong> ${response.family.pincode}
                        </p>

                        <p>
                            <strong>Marital Status:</strong> ${response.family.marital_status}
                        </p>

                    </div>

                </div>
            `;


            html += `
                <h5 class="mb-3">Family Members</h5>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Birthdate</th>
                            <th>Marital Status</th>
                            <th>Education</th>
                        </tr>
                    </thead>

                    <tbody>
            `;


            if ( response.members.length != 0 ) {
                response.members.forEach(function(member){

                    html += `
                        <tr>

                            <td width="80">
                                <img src="${member.photo_url}" 
                                    class="rounded-circle border"
                                    width="60">
                            </td>

                            <td>${member.name}</td>

                            <td>${member.birthdate_formatted}</td>

                            <td>${member.marital_status}</td>

                            <td>${member.education}</td>

                        </tr>
                    `;

                });
            } else {
                html += `
                    <tr>
                        <td colspan="5" class="text-center">
                            No family members found.
                        </td>
                    </tr>
                `;
            }


            html += `
                    </tbody>
                </table>
            `;


            $('#familyDetailsBody').html(html);

            $('#familyModal').modal('show');

        }

    });
}

</script>

@endsection