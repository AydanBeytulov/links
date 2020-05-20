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
                                            View order #{{ $data->id }}
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

                                @if(!$data->approved && $data->paid != 'closed')
                                    <div class="kt-portlet kt-portlet--skin-solid kt-portlet-- kt-bg-danger">
                                        <div class="kt-portlet__head">
                                            <div class="kt-portlet__head-label">
														<span class="kt-portlet__head-icon">
															<i class="flaticon-notes"></i>
														</span>
                                                <h3 class="kt-portlet__head-title">
                                                    Waiting for admin approve
                                                </h3>
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
                                                        <td><b>Category</b></td>
                                                        <td>{{$data->categoryData? $data->categoryData->name: ""}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Service</b></td>
                                                        <td>{{$data->serviceData? $data->serviceData->name: "" }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Description</b></td>
                                                        <td>{{ $data->description }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Link</b></td>
                                                        <td>{{ $data->url }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Quantity</b></td>
                                                        <td>{{ $data->qty }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Quantity processed</b></td>
                                                        <td>{{ $data->qtyProc }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Pay status</b></td>
                                                        <td><b>{{ $data->paid }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Status</b></td>
                                                        <td><b>{{ $data->active ? "active" : "stopped" }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Approved</b></td>
                                                        <td><b>{{ $data->approved ? "Approved" : "Waiting" }}</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Price USD</b></td>
                                                        <td>{{ $data->price }}</td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    @if($data->paid == 'payed' && $data->approved)
                                       @if($data->active)
                                            <div class="kt-invoice__actions">
                                                <div class="kt-invoice__container">
                                                    <a href="{{ route('orders_stop', $data->id) }}" class="btn btn-primary btn-bold">Pause</a>
                                                </div>
                                            </div>
                                       @else

                                            <div class="kt-invoice__actions">
                                                <div class="kt-invoice__container">
                                                    <a href="{{ route('orders_activate', $data->id) }}" class="btn btn-primary btn-bold">Activate</a>
                                                </div>
                                            </div>
                                       @endif
                                    @endif




                                </div>
                            </div>
    @if($data->paid == 'payed')
                                <div class="kt-portlet__body">
                                    <h5>Close order and get back rest of money</h5>



                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td><b>Funds spend (USD)</b></td>
                                            <td>{{ $money_back['spend'] }}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Funds left (USD)</b></td>
                                            <td>{{ $money_back['back'] }}</td>
                                        </tr>
                                        </tbody>
                                    </table>


                                </div>
                                <div class="kt-portlet__foot">
                                    <div class="kt-form__actions">
                                        <a href="{{ route('orders_close', $data->id) }}" class="btn btn-danger text-white">Close order and get back ({{ $money_back['back'] }} USD)</a>
                                    </div>
                                </div>
        @endif
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



