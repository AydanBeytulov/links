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
                                           Settings
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

                                <form class="kt-form" method="post" action="{{ route('admin_settings_edit_process') }}">
                                    @csrf


                                    <div class="kt-portlet__body">
                                        <div class="form-group">
                                            <label>Over delivery (%)</label>
                                            <input type="number" name="overdelivery" class="form-control" placeholder="0" value="{{ $settings['overdelivery'] }}">
                                        </div>

                                        <div class="form-group">
                                            <label>Price per 1000 (USD) default </label>
                                            <input type="number" name="price_per_pack" class="form-control" placeholder="0" value="{{ $settings['price_per_pack'] }}" step="0.01">
                                        </div>
                                        <div class="form-row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Order min quantity</label>
                                                    <input type="number" name="order_min_qty" class="form-control" min="0" placeholder="20" value="{{ $settings['order_min_qty'] }}" step="">
                                                </div>
                                            </div>
                                            <div class="col"> 
                                                <div class="form-group">
                                                    <label>Order max quantity</label>
                                                    <input type="number" name="order_max_qty" class="form-control" min="0" placeholder="20000" value="{{ $settings['order_max_qty'] }}" step="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="urlChoice">Blocked Countries</label>
                                            {{--                                            class="kt-dual-listbox"--}}
                                            <select id="urlChoice"  class="kt-dual-listbox" style="height: 500px" name="blocked_countries[]" multiple data-available-title="All countries" data-selected-title="Blocked countries">
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->code }}" {{ $country->blocked? "selected": "" }}>{{ $country->country }} {{ $country->iso_code_2?  "(".$country->iso_code_2.")" : "" }} </option>
                                                @endforeach
                                            </select>
                                        </div>


                                    </div>

                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Edit</button>
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



