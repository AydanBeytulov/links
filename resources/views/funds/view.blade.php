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

                            <!--begin::Portlet-->
                            <div class="kt-portlet">
                                <div class="kt-portlet__head">
                                    <div class="kt-portlet__head-label">
                                        <h3 class="kt-portlet__head-title">
                                            View fund history #{{ $data->id }}
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


                                @if($data->status == 'Waiting')

                                    <div class="kt-portlet kt-portlet--skin-solid kt-portlet-- kt-bg-danger">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
														<span class="kt-portlet__head-icon">
															<i class="flaticon-notes"></i>
														</span>
                                                <h3 class="kt-portlet__head-title">
                                                    Funding is unpaid
                                                </h3>
                                            </div>

                                        </div>
                                        <div class="kt-portlet__body">

                                            <div class="form-group ">
                                                <label>Pay address</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled="disabled" value="{{ $data->pay_address }}">
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <label>Amout to pay (BTC)</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" disabled="disabled" value="{{ $data->btc_price }}">
                                                </div>
                                            </div>

                                            <div class="form-group ">
                                                <div class="input-group">
                                                    <a class="btn btn-primary btn-bold" target="_blank" style="margin-right: 15px" href="{{ $data->checkout_url }}">Pay now</a>
                                                    <a class="btn btn-primary btn-bold" target="_blank" href="{{ $data->status_url }}">Check Status</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endif


                                <div class="kt-invoice-1">
                                    <div class="kt-invoice__body">
                                        <div class="kt-invoice__container">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <td><b>Amout (USD)</b></td>
                                                        <td>{{ $data->funds}}</td>

                                                    </tr>
                                                    <tr>
                                                        <td><b>Status</b></td>
                                                        <td>{{ $data->status }}</td>

                                                    </tr>
                                                    <tr>
                                                        <td><b>Compete date</b></td>
                                                        <td>{{ $data->competeDate? $data->competeDate: "Not completed" }}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Created at</b></td>
                                                        <td>{{ $data->created_at}}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>




                                </div>


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



