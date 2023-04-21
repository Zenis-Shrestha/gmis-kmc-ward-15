<table>
    <thead>
        <tr>
        <th align="right" width="20"><h1><strong>Bin</strong></h1></th>
        <th align="right" width="20"><h1><strong>Ward</strong></h1></th>
        <th align="right" width="20"><h1><strong>Tax Payer Code</strong></h1></th>
        <th align="right" width="20"><h1><strong>Road Name</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Number</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Owner Name</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Owner Number</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Owner Email</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Type</strong></h1></th>
        <th align="right" width="20"><h1><strong>Length</strong></h1></th>
        <th align="right" width="20"><h1><strong>Width</strong></h1></th>
        <th align="right" width="20"><h1><strong>Area</strong></h1></th>
        <th align="right" width="20"><h1><strong>Renter Name</strong></h1></th>
        <th align="right" width="20"><h1><strong>Rent Purpose</strong></h1></th>
        <th align="right" width="20"><h1><strong>Rent Start</strong></h1></th>
        <th align="right" width="20"><h1><strong>Monthly Rent</strong></h1></th>
        <th align="right" width="20"><h1><strong>Rent Tax Reponsible</strong></h1></th>
        <th align="right" width="20"><h1><strong>Rent Increase per Year</strong></h1></th>
        <th align="right" width="20"><h1><strong>Rent Mobile Number</strong></h1></th>
        <th align="right" width="20"><h1><strong>Remarks</strong></h1></th>
</tr>
</thead>
<tbody>
@foreach($buildingResults as $building)
    <tr>
    <td>{{$building->bin}}</td>    
       <td>{{$building->ward}}</td> 
       <td>{{$building->taxpayercode}}</td>
       <td>{{$building->roadname}}</td>
       <td>{{$building->houseno}}</td>
       <td>{{$building->hownername}}</td>
       <td>{{$building->hownernumber}}</td>
       <td>{{$building->howneremail}}</td>
       <td>{{$building->housetype}}</td>
       <td>{{$building->length}}</td>
       <td>{{$building->width}}</td>
       <td>{{$building->area}}</td>
       <td>{{$building->rentername}}</td>
       <td>{{$building->rentpurpose}}</td>
       <td>{{$building->rentstart}}</td>
       <td>{{$building->monthlyrent}}</td>
       <td>{{$building->rentaxresponsible}}</td>
       <td>{{$building->rentincreseperyear}}</td>
       <td>{{$building->rentmobilenumber}}</td>
       <td>{{$building->remarks}}</td>
</tr>
@endforeach
</tbody>
</table>