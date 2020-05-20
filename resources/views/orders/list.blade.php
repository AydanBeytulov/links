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
                                            Account funds
                                        </h3>
                                    </div>

                                </div>
                                <div class="kt-portlet__body">

                                    <div class="form-group ">
                                        <label>Available funds</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" disabled="disabled" value="${{ Auth::user()->funds }}">
                                            <div class="input-group-append">
                                                <a class="btn btn-warning" href="{{ route('funds_add') }}">Add funds</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="kt-container  kt-grid__item kt-grid__item--fluid">

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="kt-font-brand flaticon2-line-chart"></i>
												</span>
                                <h3 class="kt-portlet__head-title">
                                   Orders List
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">

                                        <a href="{{ route('orders_add') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            New order
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kt-portlet__body">

                            <!--begin: Datatable -->
                            <table class="table table-striped- table-bordered table-hover table-checkable" id="kt_table_1">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Service</th>
                                    <th>Link</th>
                                    <th>Quantity</th>
                                    <th>Quantity processed</th>
                                    <th>Pay status</th>
                                    <th>Status</th>
                                    <th>Approved</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->categoryData? $order->categoryData->name: ""}}</td>
                                            <td>{{$order->serviceData? $order->serviceData->name: "" }}</td>
                                            <td>{{$order->url}}</td>
                                            <td>{{$order->qty}}</td>
                                            <td>{{$order->qtyProc}}</td>
                                            <td>{{$order->paid}}</td>
                                            <td>{{$order->active}}</td>
                                            <td>{{$order->approved}}</td>
                                            <td nowrap><a href="{{ route('orders_edit', $order->id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View"> <i class="la la-edit"></i></a> </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!--end: Datatable -->
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
        "use strict";
        var KTDatatablesBasicPaginations = function() {

            var initTable1 = function() {
                var table = $('#kt_table_1');

                // begin first table
                table.DataTable({
                    responsive: true,
                    pagingType: 'full_numbers',
                    columnDefs: [

                        {
                            targets: 5,
                            render: function(data, type, full, meta) {
                                var status = {
                                    'unpaid': {'title': 'Unpaid', 'state': 'danger'},
                                    'wait': {'title': 'Wait', 'state': 'primary'},
                                    'payed': {'title': 'Paid', 'state': 'success'},
                                    'closed': {'title': 'Closed', 'state': 'primary'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                                    '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                            },
                        },

                        {
                            targets: 6,
                            render: function(data, type, full, meta) {
                                var status = {
                                    0: {'title': 'Stopped', 'state': 'danger'},
                                    1: {'title': 'Active', 'state': 'success'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                                    '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                            },
                        },

                        {
                            targets: 7,
                            render: function(data, type, full, meta) {
                                var status = {
                                    0: {'title': 'Waiting', 'state': 'danger'},
                                    1: {'title': 'Approved', 'state': 'success'},
                                };
                                if (typeof status[data] === 'undefined') {
                                    return data;
                                }
                                return '<span class="kt-badge kt-badge--' + status[data].state + ' kt-badge--dot"></span>&nbsp;' +
                                    '<span class="kt-font-bold kt-font-' + status[data].state + '">' + status[data].title + '</span>';
                            },
                        },
                    ],
                });
            };

            return {

                //main function to initiate the module
                init: function() {
                    initTable1();
                }
            };
        }();

        jQuery(document).ready(function() {
            KTDatatablesBasicPaginations.init();
        });

    </script>

@endsection



