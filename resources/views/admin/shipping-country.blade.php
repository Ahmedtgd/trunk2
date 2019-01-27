@extends("common.default")

@section("content")
    <div class="container" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 col-xs-12">
                @include('admin/leftSidebar')
            </div>

            <div class="col-sm-9 col-xs-12 margin-top">
                <div class='col-xs-12 main-header-sales-analysis'>
                    <div class='col-xs-12'>
                        <h2>Delivery Master: By Country & State</h2>
                    </div>
                    <br/><br/><br/>
                    <div class="col-xs-12 col-md-5 col-sm-6">
                        <select onchange="getDataByCountryCode()" class="form-control country-dropdown">]
                            <option value="none">--select country--</option>
                            @foreach($countries as $country)
                                <option value="{{ $country['code'] }}">{{ $country['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xs-12 col-md-5 col-sm-6">
                        <select onchange="getDataByStateCode()" class="form-control state-dropdown">]
                            <option value="none">--select state--</option>
                        </select>
                    </div>
                </div>

                <div class="tableData">

                </div>
            </div>
        </div>
    </div>
@stop

<script type="text/javascript">

    function getDataByCountryCode()
    {
        var countryCode = $('.country-dropdown option:selected').val();

        $.ajax({
            url: '{{ route('states-by-country') }}',
            cache: false,
            method: 'GET',
            data: {countryCode: countryCode},
            beforeSend: function() {
            },
            success: function(result) {
                $('.state-dropdown').html(result);
            }
        });

        $.ajax({
            url: '{{ route('sales-by-country') }}',
            cache: false,
            method: 'GET',
            data: {countryCode: countryCode},
            beforeSend: function() {
            },
            success: function(result) {
                $('.tableData').html(result);
            }
        });
    }

    function getDataByStateCode()
    {
        var stateCode = $('.state-dropdown option:selected').val();

        $.ajax({
            url: '{{ route('sales-by-state') }}',
            cache: false,
            method: 'GET',
            data: {stateCode: stateCode},
            beforeSend: function() {
            },
            success: function(result) {
                $('.tableData').html(result);
            }
        });
    }
</script>
