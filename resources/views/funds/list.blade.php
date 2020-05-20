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
                                            <input type="text" class="form-control" disabled="disabled" value="${{ Auth::user()->funds }} ">
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
                                    Funds History
                                </h3>
                            </div>
                            <div class="kt-portlet__head-toolbar">
                                <div class="kt-portlet__head-wrapper">
                                    <div class="kt-portlet__head-actions">

                                        <a href="{{ route('funds_add') }}" class="btn btn-brand btn-elevate btn-icon-sm">
                                            <i class="la la-plus"></i>
                                            Add funds
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
                                    <th>Amount (USD)</th>
                                    <th>Date</th>
                                    <th>Date completed</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($funds as $fund)
                                    <tr>
                                        <td>{{$fund->id}}</td>
                                        <td>{{$fund->funds}}</td>
                                        <td>{{$fund->created_at}}</td>
                                        <td>{{ $fund->competeDate? $fund->competeDate: "Not completed" }}</td>
                                        <td>{{$fund->status}}</td>
                                        <td nowrap><a href="{{ route('funds_view', $fund->id) }}" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="View"> <i class="la la-edit"></i></a> </td>
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
                            targets: 4,
                            render: function(data, type, full, meta) {
                                var status = {
                                    'Waiting': {'title': 'Waiting', 'state': 'danger'},
                                    'Completed': {'title': 'Completed', 'state': 'success'},
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



