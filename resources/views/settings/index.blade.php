@extends('layouts.app')

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

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="kt-font-brand flaticon2-line-chart"></i>
												</span>
                                <h3 class="kt-portlet__head-title">
                                    Profile
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


                        <form class="kt-form" method="post" action="{{ route('users_edit_process') }}">
                            @csrf

                            <input type="hidden" value="{{ $data->id }}" name="edit_id">

                            <div class="kt-portlet__body">

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $data->name }}">
                                </div>
                                <div class="form-group">
                                    <label>Email address <div class='text-danger'>{{ $data->can_change_email? "":"Cannot be changed. Contact administrator for more information." }}</div></label>
                                    <input type="email" name="email" class="form-control " aria-describedby="emailHelp" placeholder="Email" value="{{ $data->email }}" {{ $data->can_change_email? "":"readonly" }}>
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
                                    <button type="reset"  class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>

                        <form class="kt-form" method="post" action="{{ route('users_edit_process_password') }}">
                            @csrf

                            <input type="hidden" value="{{ $data->id }}" name="edit_id">

                            <div class="kt-portlet__body">
                                <h5>Change password</h5>
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
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- end:: Content -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')


@endsection



