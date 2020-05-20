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
                                            Edit rotator #{{ $data->id }}
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
                                <form class="kt-form" method="post" action="{{ route('admin_rotators_edit_process') }}">
                                    @csrf

                                    <input type="hidden" value="{{ $data->id }}" name="edit_id">

                                    <div class="kt-portlet__body">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $data->name }}">
                                        </div>

                                        <div class="form-group">
                                            <label for="serviceSelect">Service</label>
                                            <select class="form-control" id="serviceSelect" name="service">
                                                @foreach($services as $service)
                                                    <option value="{{ $service['id'] }}" {{ $data->service == $service->id ? "selected" : "" }}>{{ $service['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="urlChoice">URLs</label>
                                            {{--                                            --}}
                                            <select id="urlChoice" style="height: 500px" name="urls[]" class="kt-dual-listbox" multiple data-available-title="URLs available" data-selected-title="Rotator's urls">
                                                @foreach($urls as $url)
                                                    <option value="{{ $url->id }}" {{ in_array($url->id,$selected_urls) ? "selected" : "" }}> {{ $url->url }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="kt-checkbox-list">
                                                <label class="kt-checkbox">
                                                    <input type="checkbox" name="active" {{ $data->active ? "checked" : "" }}> Active
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                            <a href="{{ route('admin_rotators') }}" class="btn btn-secondary">Cancel</a>

                                            <a href="{{ route('admin_rotators_delete',$data->id) }}" class="btn btn-danger float-right">Delete</a>
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

    <style>
        .dual-listbox .dual-listbox__container .dual-listbox__selected, .dual-listbox .dual-listbox__container .dual-listbox__available{
            width: 450px;
        }
    </style>

    <script>
        'use strict';

        // Class definition
        var KTDualListbox = function() {

            // Private functions
            var initDualListbox = function() {
                // Dual Listbox
                var listBoxes = $('.kt-dual-listbox');

                listBoxes.each(function() {
                    var $this = $(this);
                    // get titles
                    var availableTitle = ($this.attr('data-available-title') != null) ? $this.attr('data-available-title') : 'Available options';
                    var selectedTitle = ($this.attr('data-selected-title') != null) ? $this.attr('data-selected-title') : 'Selected options';

                    // get button labels
                    var addLabel = ($this.attr('data-add') != null) ? $this.attr('data-add') : 'Add';
                    var removeLabel = ($this.attr('data-remove') != null) ? $this.attr('data-remove') : 'Remove';
                    var addAllLabel = ($this.attr('data-add-all') != null) ? $this.attr('data-add-all') : 'Add All';
                    var removeAllLabel = ($this.attr('data-remove-all') != null) ? $this.attr('data-remove-all') : 'Remove All';


                    // init dual listbox
                    var dualListBox = new DualListbox($this.get(0), {
                        availableTitle: availableTitle,
                        selectedTitle: selectedTitle,
                        addButtonText: addLabel,
                        removeButtonText: removeLabel,
                        addAllButtonText: addAllLabel,
                        removeAllButtonText: removeAllLabel,
                    });
                });
            };

            return {
                // public functions
                init: function() {
                    initDualListbox();
                },
            };
        }();

        KTUtil.ready(function() {
            KTDualListbox.init();
        });

    </script>

@endsection



