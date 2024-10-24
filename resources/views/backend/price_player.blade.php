@extends('backend.layouts.app')

@section('content')

<div class="aiz-titlebar text-left mt-2 mb-3">
	<div class="row align-items-center">
		<div class="col">
			<h1 class="h3">{{ translate('Price Player') }}</h1>
		</div>
	</div>
</div>

<!-- Success and Error Messages -->
<div class="row">
	<div class="col-md-8 mx-auto">
		<!-- Success Message -->
		@if (session('message'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				{{ session('message') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif

		<!-- General Error Message -->
		@if (session('error'))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				{{ session('error') }}
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif

		<!-- Validation Errors -->
		@if ($errors->any())
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		@endif
	</div>
</div>

<!-- Main Content -->
<div class="row">
	<div class="col-md-8 mx-auto">
		<div class="card">
			<div class="card-body">
				<form action="{{ route('user_price_settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Header Nav Menus -->
                    <label class="">{{ translate('User Label') }}</label>
                    <div class="header-nav-menu">
                        <input type="hidden" name="types[]" value="user_labels">
                        <input type="hidden" name="types[]" value="user_price">
                        <input type="hidden" name="types[]" value="type">
                        @if ($users != null)
                        @foreach ($users as $key => $user)
                        <div class="row gutters-5">
                            <!-- User Dropdown -->
                            <div class="col-4">
                                <div class="form-group">
                                    <select class="form-control" name="user_labels[]">
                                        <option value="">{{ translate('Select User') }}</option>
                                        @foreach ($users as $singleUser)
                                            <option value="{{ $singleUser->id }}" {{ $user->id == $singleUser->id ? 'selected' : '' }}>
                                                {{ $singleUser->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                            <!-- Price Input Field -->
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="text" maxLength="5" fieldType="float" class="form-control" placeholder="{{ translate('Enter Price') }}" name="user_price[]" value="{{ $user->user_price->price ?? '' }}">
                                </div>
                            </div>
                    
                            <!-- Type Dropdown -->
                            <div class="col-4">
                                <div class="form-group">
                                    <select class="form-control" name="type[]">
                                        <option value="">{{ translate('Type') }}</option>
                                        <option value="Multiply" {{ isset($user->user_price->type) && $user->user_price->type == 'Multiply' ? 'selected' : '' }}>Multiply</option>
                                        <option value="Add" {{ isset($user->user_price->type) && $user->user_price->type == 'Add' ? 'selected' : '' }}>Add</option>
                                        <option value="Percentage" {{ isset($user->user_price->type) && $user->user_price->type == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                </div>
                            </div> 
                    
                            <!-- Remove Button -->
                            <div class="col-auto">
                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm  btn-soft-danger" data-id="{{@$user->user_price->id}}" data-toggle="remove-parent" data-parent=".row">
                                    <i class="las la-times"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                        @endif
                    </div>
                
                    <!-- Add New Button -->
                    <button
                        type="button"
                        class="btn btn-soft-secondary btn-sm"
                        data-toggle="add-more"
                        data-content='<div class="row gutters-5">
                            <div class="col-4">
                                <div class="form-group">
                                    <!-- Dropdown Single Select -->
                                    <select class="form-control" name="user_labels[]">
                                        <option value="">{{ translate('Select User') }}</option>
                                        @foreach ($users as $singleUser)
                                            <option value="{{ $singleUser->id }}">{{ $singleUser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="text" maxLength="5" fieldType="float" class="form-control" placeholder="{{ translate('Enter Price') }}" name="user_price[]">
                                </div>
                            </div>
                             <div class="col-4">
                                 <div class="form-group">
                                    <select class="form-control" name="type[]">
                                        <option value="">{{ translate('Type') }}</option>
                                            <option value="Multiply">Multiply</option>
                                            <option value="Add">Add</option>
                                            <option value="Percentage">Percentage</option>
                                       
                                    </select>
                                </div>
                                </div>
                            <div class="col-auto">
                                <button type="button" class="mt-1 btn btn-icon btn-circle btn-sm btn-soft-danger" data-id="" data-toggle="remove-parent" data-parent=".row">
                                    <i class="las la-times"></i>
                                </button>
                            </div>
                        </div>'
                        data-target=".header-nav-menu">
                        {{ translate('Add New') }}
                    </button>
                
                    <!-- Update Button -->
                    <div class="mt-4 text-right">
                        <button type="submit" class="btn btn-success w-230px btn-md rounded-2 fs-14 fw-700 shadow-success">{{ translate('Update') }}</button>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('input').on('input', function() {
        const maxLength = $(this).attr('maxLength');
        const fieldType = $(this).attr('fieldType');

        // Max length validation
        if (maxLength && $(this).val().length >= maxLength) {
            $(this).val($(this).val().substring(0, maxLength)); // Trim input to maxLength
        }

        // Type validation
        switch (fieldType) {
            case 'num':
                // Allow only numeric values
                $(this).val($(this).val().replace(/[^0-9]/g, '')); // Remove non-numeric characters
                break;
            case 'float':
                // Allow floating-point values
                $(this).val($(this).val().replace(/[^0-9.]/g, '')); // Remove non-numeric and non-decimal characters
                // Allow only one decimal point
                if ($(this).val().split('.').length > 2) {
                    $(this).val($(this).val().substring(0, $(this).val().lastIndexOf('.')) + '.');
                }
                break;
            case 'alphanum':
                // Allow only alphanumeric characters
                $(this).val($(this).val().replace(/[^a-zA-Z0-9]/g, '')); // Remove non-alphanumeric characters
                break;
        }
    });


    $('body').on('click', '.btn-soft-danger', function() {
    let id = $(this).data('id');
    // Confirm the deletion
    if (id && id !== '') {
        if (confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                url: '/admin/user-price-settings/delete/' + id, // Adjust the URL according to your routing
                type: 'Get', // Specify the DELETE method
                data: {
                    _token: '{{ csrf_token() }}' // Include CSRF token for security
                },
                success: function(response) {
                    // Handle success - e.g., show a success message or remove the element from the DOM
                    alert("Record deleted successfully.");
                    // Optionally, remove the corresponding row or element from the UI
                    // $(this).closest('.row').remove(); // Adjust this selector as necessary
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert("An error occurred: " + xhr.responseText);
                }
            });
        }
    } 
});

});
</script>


@endsection
