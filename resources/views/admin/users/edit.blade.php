@extends('admin.layouts.app')

@section('content')
    <!-- end:: Header -->
    <div class="kt-container  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch">
        <div class="kt-body kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-grid--stretch" id="kt_body">
            <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

                <div class="kt-subheader   kt-grid__item" id="kt_subheader">
                    <div class="kt-container ">
                    </div>
                </div>


                <!-- begin:: Content -->
                <div class="kt-container  kt-grid__item kt-grid__item--fluid">
                    <div class="row">
                        <div class="col-md-12">

                            <!--begin::Portlet-->
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Edit User #{{ $data->id }}
                                        </h3>
                                    </div>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                            @endif
                            <!--begin::Form-->
                                <form class="kt-form" method="post" action="{{ route('admin_users_edit_process') }}">
                                    @csrf

                                    <input type="hidden" value="{{ $data->id }}" name="edit_id">

                                    <div class="kt-portlet__body">

                                        <div class="form-group">
                                            <label>Type</label>
                                            <select name="type" class="form-control">
                                                <option value="default" {{ $data->type == 'default' ? 'selected' : "" }}>User</option>
                                                <option value="fast" {{ $data->type == 'fast' ? 'selected' : "" }}>Fast user</option>
                                                <option value="admin" {{ $data->type == 'admin' ? 'selected' : "" }}>Admin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $data->name }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Email address</label>
                                            <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Email" value="{{ $data->email }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" name="address" class="form-control" placeholder="Address" value="{{ $data->address }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" name="phone" class="form-control"  placeholder="Phone" value="{{ $data->phone }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Can change email</label>
                                            <div class="kt-checkbox-list">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="can_change_email" {{ $data->can_change_email? "checked": "" }}> Active
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Step2 verification</label>
                                            <div class="kt-checkbox-list">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="twostep" {{ $data->twostep? "checked": "" }}> Enable Step2 verification
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                            <a href="{{ route('admin_users') }}" class="btn btn-secondary">Cancel</a>

                                            <a href="{{ route('admin_users_delete',$data->id) }}" class="btn btn-danger float-right">Delete</a>
                                        </div>
                                    </div>
                                </form>


                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            User funds
                                        </h3>
                                    </div>
                                </div>

                                <form class="kt-form" method="post" action="{{ route('admin_users_edit_process_funds') }}">
                                    @csrf

                                    <input type="hidden" value="{{ $data->id }}" name="edit_id">

                                    <div class="kt-portlet__body">

                                        <div class="form-group">
                                            <label>User available funds (USD):</label><b> {{ $data->funds }}</b>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Funds to add (USD)</label>
                                            <input type="text" name="funds" class="form-control" placeholder="0.00">
                                        </div>



                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Add funds</button>
                                            <a href="{{ route('admin_users') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </form>


                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Change password
                                        </h3>
                                    </div>
                                </div>

                                <form class="kt-form" method="post" action="{{ route('admin_users_edit_process_password') }}">
                                    @csrf

                                    <input type="hidden" value="{{ $data->id }}" name="edit_id">

                                    <div class="kt-portlet__body">

                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Password</label>
                                            <input type="password" name="password" class="form-control"  placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Confirm password</label>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password">
                                        </div>



                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Change password</button>
                                            <a href="{{ route('admin_users') }}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </form>



                                <!--end::Form-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end:: Content -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>

@endsection



