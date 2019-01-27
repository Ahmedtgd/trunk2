<div class="table-responsive" style="width: 100%;">
    <table class="table table-bordered" id="supplier-open-channel">
        <tr style="background-color: #101010; color: white;">
            <td colspan="11">Shipping</td>
        </tr>
        <tr style="background-color: #101010; color: white;">
            <td>Merchant ID</td>
            <td>User ID</td>
            <td>Company Name</td>
            <td>GST</td>
            <td>Business Registration Number</td>
            <td>Business type</td>
            <td>Contact Person</td>
            <td>Office Number</td>
            <td>Mobile Number</td>
            <td>O Shop Name</td>
            <td>Description</td>
        </tr>
        <tr>
            <td align="center"><p style="color: darkblue;">[{{ $merchant->getPrefixofID($merchant->id) }}]</p></td>
            <td align="center">{{ $merchant->user_id }}</td>
            <td align="center">{{ $merchant->company_name }}</td>
            <td align="center">{{ $merchant->gst }}</td>
            <td align="center">{{ $merchant->business_reg_no }}</td>
            <td align="center">{{ $merchant->business_type }}</td>
            <td align="center">{{ $merchant->contact_person }}</td>
            <td align="center">{{ $merchant->office_no }}</td>
            <td align="center">{{ $merchant->mobile_no }}</td>
            <td align="center">{{ $merchant->oshop_name }}</td>
            <td align="center">{{ $merchant->description }}</td>
        </tr>
    </table>
</div>


