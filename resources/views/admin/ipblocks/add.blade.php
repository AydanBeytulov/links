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
                                            Add IP block
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
                                <form class="kt-form" method="post" action="{{ route('admin_ip_blocks_add_process') }}">
                                    @csrf

                                    <div class="kt-portlet__body">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}">
                                        </div>

                                        <div class="form-group">
                                            <label>IP</label>
                                            <input type="text" name="ip" class="form-control" placeholder="IP" value="{{ old('ip') }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="kt-checkbox-list">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="active"> Active
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                            <a href="{{ route('admin_ip_blocks') }}" class="btn btn-secondary">Cancel</a>
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



