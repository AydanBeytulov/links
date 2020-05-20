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
                                            Add Order
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
                                <form class="kt-form" method="post" action="{{ route('orders_add_process') }}">
                                    @csrf

                                    <input type="hidden" id="price_per_pack" value="{{ $price_per_pack }}">

                                    <div class="kt-portlet__body">

                                        <div class="form-group">
                                            <label for="categorySelect">Category</label>
                                            <select class="form-control" id="categorySelect" name="category">
                                               @foreach($categories as $category)
                                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                               @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="serviceSelect">Service</label>
                                            <select class="form-control" id="serviceSelect" name="service">
                                                @foreach($services as $service)
                                                    <option value="{{ $service['id'] }}" data-cat-id="{{ $service['category'] }}" data-rate="{{ $service['rate'] }}">{{ $service['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group ">
                                            <label for="descTextarea">Description</label>
                                            <textarea class="form-control" id="descTextarea" rows="3" name="description"></textarea>
                                        </div>

                                        <div class="form-group ">
                                            <label for="urlInput" >Link</label>
                                            <input class="form-control" type="url" placeholder="https://example.com" id="urlInput" name="url">
                                        </div>

                                        <div class="form-group ">
                                            <label for="Quantityinput">Quantity</label>
                                            <input class="form-control" type="number" placeholder="Min: {{ \App\Http\Controllers\Admin\SettingsController::getSetting('order_min_qty') }} - Max: {{ \App\Http\Controllers\Admin\SettingsController::getSetting('order_max_qty') }}" id="Quantityinput" name="qty" min="{{ \App\Http\Controllers\Admin\SettingsController::getSetting('order_min_qty') }}" max="{{ \App\Http\Controllers\Admin\SettingsController::getSetting('order_max_qty') }}">
                                        </div>

                                        <div class="form-group form-group-last">
                                            <label>Charge</label>
                                            <input type="text" id="chargeShow" class="form-control" readonly="" value="$0.00">
                                        </div>

                                    </div>
                                    <div class="kt-portlet__foot">
                                        <div class="kt-form__actions">
                                            <button type="submit" class="btn btn-primary">Maker order</button>
                                            <button type="reset" class="btn btn-secondary">Cancel</button>
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
        $(document).ready(function(){
            $('#Quantityinput').change(function(){
                calculateCarge();
            });
            $('#Quantityinput').keyup(function(){
                calculateCarge();
            });

            fixServices();

            $('#categorySelect').change(function(){
                fixServices();
                calculateCarge();
            });

            $('#serviceSelect').change(function(){
                calculateCarge();
            });


        });

        function fixServices() {
            var selectedCategory = $('#categorySelect').val();
            $("#serviceSelect option[data-cat-id='"+selectedCategory+"']").show();
            $("#serviceSelect option[data-cat-id!='"+selectedCategory+"']").hide();
            $("#serviceSelect option").removeAttr('selected');
            $("#serviceSelect option[data-cat-id='"+selectedCategory+"']").attr('selected','selected');
        }

        function calculateCarge(){

            var selecredService = $('#serviceSelect').val();
            var get_option = $("#serviceSelect option[value='"+selecredService+"']");

            var pricePerThousand = 0 ;

            if(get_option.data('rate') > 0){
                pricePerThousand = get_option.attr('data-rate');
            }else{
                pricePerThousand = $('#price_per_pack').val();
            }

            var val = $('#Quantityinput').val();


            var charge = "0.00";

            charge  = Math.ceil10(((val / 1000) * pricePerThousand) , -2); // Math.round((((val / 1000) * pricePerThousand) + Number.EPSILON) * 100) / 100;

            $('#chargeShow').val('$ '+charge);

        }


        function round_up( value, precision) {
            var pow = Math.pow(10, precision);
            return (Math.ceil( pow / value ) + Math.ceil( pow * value - Math.ceil( pow * value ))) / pow;
        }




        (function() {
            /**
             * Decimal adjustment of a number.
             *
             * @param {String}  type  The type of adjustment.
             * @param {Number}  value The number.
             * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
             * @returns {Number} The adjusted value.
             */
            function decimalAdjust(type, value, exp) {
                // If the exp is undefined or zero...
                if (typeof exp === 'undefined' || +exp === 0) {
                    return Math[type](value);
                }
                value = +value;
                exp = +exp;
                // If the value is not a number or the exp is not an integer...
                if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
                    return NaN;
                }
                // Shift
                value = value.toString().split('e');
                value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
                // Shift back
                value = value.toString().split('e');
                return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
            }

            // Decimal round
            if (!Math.round10) {
                Math.round10 = function(value, exp) {
                    return decimalAdjust('round', value, exp);
                };
            }
            // Decimal floor
            if (!Math.floor10) {
                Math.floor10 = function(value, exp) {
                    return decimalAdjust('floor', value, exp);
                };
            }
            // Decimal ceil
            if (!Math.ceil10) {
                Math.ceil10 = function(value, exp) {
                    return decimalAdjust('ceil', value, exp);
                };
            }
        })();
    </script>

@endsection
