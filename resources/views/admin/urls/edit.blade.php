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
                                            Edit URL #{{ $data->id }}
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
                                <form class="kt-form" method="post" action="{{ route('admin_urls_edit_process') }}">
                                    @csrf

                                    <input type="hidden" value="{{ $data->id }}" name="edit_id">

                                    <div class="kt-portlet__body">
                                        <div class="form-group">
                                            <label>URL</label>
                                            <input type="text" name="url" class="form-control" placeholder="URL" value="{{ $data->url }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Spoof URL</label>
                                            <input type="text" name="spoof_url" class="form-control" placeholder="Spoof URL" value="{{ $data->spoof_url }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Order ID</label>
                                            <input class="form-control" type="text"  value="{{ $data->order_id }}" disabled >
                                        </div>

                                        <div class="form-group">
                                            <label>QTY</label>
                                            <input class="form-control" type="number" name="qty" placeholder="20 - 20000" value="{{ $data->qty }}" >
                                        </div>

                                        <div class="form-group">
                                            <label>QTY showed</label>
                                            <input class="form-control" type="number" name="qtyshowed" placeholder="20 - 20000" value="{{ $data->qty_showed }}" >
                                        </div>

                                        @if($data->order_id )
                                            <div class="form-group">
                                                <label>Status</label>
                                                <b>Active</b>
                                                <p>To change status, change order status here:  <a href="{{ route('admin_orders_edit',$data->order_id) }}" target="_blank">EDIT ORDER #{{ $data->order_id }}</a></p>
                                            </div>
                                        @else
                                            <div class="form-group">
                                                <label>Status</label>
                                                <div class="kt-checkbox-list">
                                                    <label class="kt-checkbox">
                                                        <input type="checkbox" name="active" {{ $data->active ? "checked" : "" }}> Active
                                                        <span></span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endif

                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                            <a href="{{ route('admin_urls') }}" class="btn btn-secondary">Cancel</a>

                                            <a href="{{ route('admin_urls_delete',$data->id) }}" class="btn btn-danger float-right">Delete</a>
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



