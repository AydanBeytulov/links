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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="kt-portlet kt-portlet--skin-solid kt-portlet-- kt-bg-brand">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
														<span class="kt-portlet__head-icon">
															<i class="flaticon-notes"></i>
														</span>
                                        <h3 class="kt-portlet__head-title">
                                            API KEY
                                        </h3>
                                    </div>

                                </div>
                                <div class="kt-portlet__body">

                                    <div class="form-group ">
                                        <label>Your api key</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" disabled="disabled" value="{{ $api_key }}">
                                            <div class="input-group-append">
                                                <a class="btn btn-warning" href="{{ route('my_api_regenerate') }}">Regenerate</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            Allowed IPs
                                        </h3>
                                    </div>
                                </div>

                                <!--begin::Form-->
                                <form class="kt-form" method="post" action="{{ route('my_api_allow_data_process') }}">
                                    @csrf
                                    <div class="kt-portlet__body">
                                        <div class="form-group form-group-last">
                                            <div class="alert alert-secondary" role="alert">
                                                <div class="alert-icon"><i class="flaticon-warning kt-font-brand"></i></div>
                                                <div class="alert-text">
                                                    You can control IPs that can use your API key. For multiple IPs separate them with ",".
                                                    <br>
                                                    Example: 88.88.88.88, 44.55.66.77, 98.76.54.32
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-last">
                                            <label for="exampleTextarea">List all allowed IPs</label>
                                            <textarea class="form-control" id="exampleTextarea" rows="3" name="allowed_data">{{ $allowed_data }}</textarea>
                                        </div>
                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Save</button>
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


@endsection



