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
                                            Edit order #{{ $data->id }}
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

                               <div class="kt-portlet__body">
                                   <div class="kt-invoice-1">
                                       <div class="kt-invoice__body">
                                           <div class="kt-invoice__container">
                                               <div class="table-responsive">
                                                   <table class="table">
                                                       <tbody>
                                                       <tr>
                                                           <td><b>User</b></td>
                                                           <td><a href="{{ route('admin_users_edit', $data->userData->id) }}">{{$data->userData->name}}</a></td>

                                                       </tr>
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
                                                           <td><b>
                                                                   @if($data->paid == "unpaid")
                                                                       <span class='text-danger'>{{ $data->paid }}</span>
                                                                   @else
                                                                       {{  $data->paid }}
                                                                   @endif


                                                               </b></td>
                                                       </tr>
                                                       <tr>
                                                           <td><b>Status</b></td>
                                                           <td><b>{{ $data->active ? "Active" : "Stopped" }}</b></td>
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

                                      @if($data->paid != "closed")

                                           @if(!$data->approved)
                                               <div class="kt-invoice__actions">
                                                   <div class="kt-invoice__container">
                                                       <a href="{{ route('admin_orders_approve', $data->id) }}" class="btn btn-primary btn-bold">Approve order</a>
                                                       <a href="{{ route('admin_orders_refuse', $data->id) }}" class="btn btn-danger btn-bold">Refuse order</a>
                                                       @if(!$data->isURL)
                                                           <a href="{{ route('admin_orders_add_url', $data->id) }}" class="btn btn-primary btn-bold">Add URL in list</a>
                                                       @endif
                                                   </div>
                                               </div>
                                           @else

                                               @if($data->active)
                                                   <div class="kt-invoice__actions">
                                                       <div class="kt-invoice__container">
                                                           <a href="{{ route('admin_orders_stop', $data->id) }}" class="btn btn-primary btn-bold">Pause</a>
                                                       </div>
                                                   </div>
                                               @else

                                                   <div class="kt-invoice__actions">
                                                       <div class="kt-invoice__container">
                                                           <a href="{{ route('admin_orders_activate', $data->id) }}" class="btn btn-primary btn-bold">Activate</a>
                                                       </div>
                                                   </div>
                                               @endif

                                           @endif

                                      @endif



                                   </div>

                               </div>

                            <!--begin::Form-->


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



