<table>
    <thead>
        <tr>
       
        <th align="right" width="20"><h1><strong>Bin</strong></h1></th>
        <th align="right" width="20"><h1><strong>Ward</strong></h1></th>
        <th align="right" width="20"><h1><strong>Tole</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Address</strong></h1></th>
        <th align="right" width="20"><h1><strong>House Owner</strong></h1></th>
        <!-- <th align="right" width="20"><h1><strong>Yoc</strong></h1></th> -->
        <th align="right" width="20"><h1><strong>Floor Counts</strong></h1></th>
        <th align="right" width="20"><h1><strong>Building use</strong></h1></th>
        <th align="right" width="20"><h1><strong>Construction Type</strong></h1></th>
        <th align="right" width="20"><h1><strong>Tax Status</strong></h1></th> 
        <th align="right" width="20"><h1><strong>Street</strong></h1></th>
</tr>
</thead>
<tbody>
@foreach($buildingResults as $building)
    <tr>
       <td>{{$building->bin}}</td>    
       <td>{{$building->ward}}</td>   
       <td>{{$building->tole}}</td>   
       <td>{{$building->haddr}}</td>   
       <td>{{$building->hownr}}</td> 
       <td>{{$building->flrcount}}</td>    
       <td>{{$building->building_use}}</td>    
       <td>{{$building->construction_type}}</td> 
       <td>{{$building->tax_status}}</td> 
       <td>{{$building->street}}</td> 
           
</tr>
@endforeach
</tbody>
</table>