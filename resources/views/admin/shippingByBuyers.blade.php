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
                        <h2>Delivery Master: By Buyer</h2>
                    </div>
                    <br/><br/><br/>
                    <div class="col-xs-12 col-md-5 col-sm-6">
                        <select onchange="getDataByBuyer()" class="form-control state-dropdown">]
                            <option>--select--</option>
                            @foreach($buyers as $buyer)
                                <option value="{{ $buyer['id'] }}">{{ $buyer['name'] }}</option>
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

    function getDataByBuyer()
    {
        var buyerId = $('.state-dropdown option:selected').val();

        $.ajax({
            url: '{{ route('sales-by-buyer') }}',
            cache: false,
            method: 'GET',
            data: {buyerId: buyerId},
            beforeSend: function() {
            },
            success: function(result) {
                $('.tableData').html(result);
            }
        });
    }
</script>
