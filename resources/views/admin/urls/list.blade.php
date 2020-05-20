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

                    <div class="kt-portlet kt-portlet--mobile">
                        <div class="kt-portlet__head kt-portlet__head--lg">
                            <div class="kt-portlet__head-label">
												<span class="kt-portlet__head-icon">
													<i class="kt-font-brand flaticon2-line-chart"></i>
												</span>
                                <h3 class="kt-portlet__head-title">
                                    URLs List
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">

                                        <a href="{{ route('admin_urls_add') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            New URL
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
                                    <th>URL ID</th>
                                    <th>URL</th>
                                    <th>OrderId</th>
                                    <th>QTY</th>
                                    <th>QTY showed</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($urls as $url)
                                    <tr>
                                        <td>{{ $url->id }}</td>
                                        <td>{{ $url->url }}</td>
                                        <td>
                                            @if($url->order_id)
                                                <a href="{{ route('admin_orders_edit',$url->order_id) }}" target="_blank">{{ $url->order_id }}</a>
                                            @else
                                                <span class="text-danger">No Order</span>
                                            @endif
                                        </td>
                                        <td>{{ $url->qty }}</td>
                                        <td>{{ $url->qty_showed }}</td>
                                        <td>{{ $url->active }}</td>
                                        <td nowrap><a href="{{ route('admin_urls_edit', $url->id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"> <i class="la la-edit"></i></a> </td>
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



