<table>
    <thead>
        <tr>
        <th align="right" width="20"><h1><strong>Bin</strong></h1></th>
        <th align="right" width="20"><h1><strong>Ward</strong></h1></th>
        <th align="right" width="20"><h1><strong>Road Name</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Number</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Owner Name</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Owner Email</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Owner Phone</strong></h1></th>
        <th align="right" width="20"><h1><strong>Business Owner</strong></h1></th>
        <th align="right" width="20"><h1><strong>Business Name</strong></h1></th>
        <th align="right" width="20"><h1><strong>Business Type</strong></h1></th>
        <th align="right" width="20"><h1><strong>Category</strong></h1></th>
        <th align="right" width="20"><h1><strong>Business Operating Date</strong></h1></th>
        <th align="right" width="20"><h1><strong>Registration</strong></h1></th>
        <th align="right" width="20"><h1><strong>Old Internal Number</strong></h1></th>
        <th align="right" width="20"><h1><strong>Business Owner Mobile</strong></h1></th>
        <th align="right" width="20"><h1><strong>Email</strong></h1></th>
        <th align="right" width="20"><h1><strong>Remarks</strong></h1></th>
</tr>
</thead>
<tbody>
@foreach($buildingResults as $building)
    <tr>
    <td>{{$building->bin}}</td>    
       <td>{{$building->ward}}</td>
         <td>{{$building->roadname}}</td>    
       <td>{{$building->houseno}}</td>
         <td>{{$building->houseownername}}</td>    
       <td>{{$building->ownerphone}}</td> 
        <td>{{$building->houseownermail}}</td>    
       <td>{{$building->businesowner}}</td>
         <td>{{$building->businessname}}</td>    
       <td>{{$building->businesstype}}</td>  
       <td>{{$building->category}}</td>    
       <td>{{$building->businessoprdate}}</td> 
        <td>{{$building->registration}}</td>    
       <td>{{$building->oldinternalnumber}}</td> 
       <td>{{$building->businessownermobile}}</td> 
        <td>{{$building->email}}</td>    
       <td>{{$building->remarks}}</td> 
</tr>
@endforeach
</tbody>
</table>