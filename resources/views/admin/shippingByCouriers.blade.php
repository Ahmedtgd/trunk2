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
                        <h2>Delivery Master: By Courier</h2>
                    </div>
                    <br/><br/><br/>
                    <div class="col-xs-12 col-md-5 col-sm-6">
                        <select onchange="getDataByCourierID()" class="form-control state-dropdown">]
                            <option>--select--</option>
                            @foreach($couriers as $courier)
                                <option value="{{ $courier['id'] }}">{{ $courier['name'] }}</option>
                            @endforeach
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

    function getDataByCourierID()
    {
        var courierId = $('.state-dropdown option:selected').val();

        $.ajax({
            url: '{{ route('sales-by-courier') }}',
            cache: false,
            method: 'GET',
            data: {courierId: courierId},
            beforeSend: function() {
            },
            success: function(result) {
                $('.tableData').html(result);
            }
        });
    }
</script>
