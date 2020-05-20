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
                                    IP Blocks List
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">

                                        <a href="{{ route('admin_ip_blocks_add') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            New IP Block
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
                                    <th>Name</th>
                                    <th>IP</th>
                                    <th>Active</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($blocks as $block)
                                    <tr>
                                        <td>{{ $block->id }}</td>
                                        <td>{{ $block->name }}</td>
                                        <td>{{ $block->ip }}</td>
                                        <td>{{ $block->active }}</td>
                                        <td nowrap><a href="{{ route('admin_ip_blocks_edit', $block->id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit"> <i class="la la-edit"></i></a> </td>
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
                            targets: 3,
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



