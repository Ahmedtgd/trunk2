@extends("common.default")

@section("content")
    <div class="container" id="sales-analysis" style="margin-top:30px;">
        <div class="row">
            <div class="col-sm-3 col-xs-12">
                @include('admin/leftSidebar')
            </div>

            <div class="col-sm-9 col-xs-12 margin-top">
                <div class='col-xs-12 main-header-sales-analysis'>
                    <div class='col-xs-12'>
                        <h2>Delivery Master: By Merchant Consultant</h2>
                    </div>
                    <br/><br/><br/>
                    <div class="col-xs-12 col-md-5 col-sm-6">
                        <select onchange="getDataByMerchantConsultant()" class="form-control merchant-dropdown">]
                            <option>--select--</option>
                            @foreach($merchantsConsultants as $merchantsConsultant)
                                <option value="{{ $merchantsConsultant['id'] }}">{{ $merchantsConsultant['first_name'].' '.$merchantsConsultant['last_name'] }}</option>
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

    function getDataByMerchantConsultant()
    {
        var merchantId = $('.merchant-dropdown option:selected').val();

        $.ajax({
            url: '{{ route('sales-by-merchant-consultant') }}',
            cache: false,
            method: 'GET',
            data: {merchantId: merchantId},
            beforeSend: function() {
            },
            success: function(result) {
                $('.tableData').html(result);
            }
        });
    }
</script>
