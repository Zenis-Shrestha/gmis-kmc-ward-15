<table>
    <thead>
        <tr>
       
        		<th align="right" width="20"><h1><strong>BIN</strong></h1></th>   
        <th align="right" width="20"><h1><strong>bldgcd</strong></h1></th>   
        <th align="right" width="20"><h1><strong>ward</strong></h1></th>   
        <th align="right" width="20"><h1><strong>tole</strong></h1></th>   
        <th align="right" width="20"><h1><strong>oldhno</strong></h1></th>   
        <th align="right" width="20"><h1><strong>haddr</strong></h1></th>   
        <th align="right" width="20"><h1><strong>haddrplt</strong></h1></th>   
        <th align="right" width="20"><h1><strong>strtcd</strong></h1></th>   
        <th align="right" width="20"><h1><strong>imgfl</strong></h1></th>   
        <th align="right" width="20"><h1><strong>addrzn</strong></h1></th>   
        <th align="right" width="20"><h1><strong>zonecode</strong></h1></th>   
        <th align="right" width="20"><h1><strong>bldgasc</strong></h1></th>   
        <th align="right" width="20"><h1><strong>bldguse</strong></h1></th>   
        <th align="right" width="20"><h1><strong>offcnm</strong></h1></th>   
        <th align="right" width="20"><h1><strong>prclkey</strong></h1></th>   
        <th align="right" width="20"><h1><strong>yoc</strong></h1></th>   
        <th align="right" width="20"><h1><strong>flrcount</strong></h1></th>   
        <th align="right" width="20"><h1><strong>flrar</strong></h1></th>   
        <th align="right" width="20"><h1><strong>consttyp</strong></h1></th>   
        <th align="right" width="20"><h1><strong>elecyn</strong></h1></th>   
        <th align="right" width="20"><h1><strong>bprmtyn</strong></h1></th>   
        <th align="right" width="20"><h1><strong>bprmtno</strong></h1></th>   
        <th align="right" width="20"><h1><strong>buildvflag</strong></h1></th>   
        <th align="right" width="20"><h1><strong>drnkwtr</strong></h1></th>   
        <th align="right" width="20"><h1><strong>wtrcons</strong></h1></th>   
        <th align="right" width="20"><h1><strong>toilyn</strong></h1></th>   
        <th align="right" width="20"><h1><strong>wwdischg</strong></h1></th>   
        <th align="right" width="20"><h1><strong>swsegyn</strong></h1></th>   
        <th align="right" width="20"><h1><strong>sngwoman</strong></h1></th>   
        <th align="right" width="20"><h1><strong>hhcount</strong></h1></th>   
        <th align="right" width="20"><h1><strong>hhpop</strong></h1></th>   
        <th align="right" width="20"><h1><strong>gt60yr</strong></h1></th>   
        <th align="right" width="20"><h1><strong>dsblppl</strong></h1></th>   
        <th align="right" width="20"><h1><strong>datsrc</strong></h1></th>   
        <th align="right" width="20"><h1><strong>txpyrname</strong></h1></th>   
        <th align="right" width="20"><h1><strong>txpyrid</strong></h1></th>   
        <th align="right" width="20"><h1><strong>Due</strong></h1></th>   
</tr>
</thead>
<tbody>
@foreach($buildingResults as $building)
    <tr>
        <td>{{$building->bin}}</td>   
        <td>{{$building->bldgcd}}</td>   
        <td>{{$building->ward}}</td>   
        <td>{{$building->tole}}</td>   
        <td>{{$building->oldhno}}</td>   
        <td>{{$building->haddr}}</td>   
        <td>{{$building->haddrplt}}</td>   
        <td>{{$building->strtcd}}</td>   
        <td>{{$building->imgfl}}</td>   
        <td>{{$building->addrzn}}</td>   
        <td>{{$building->zonecode}}</td>   
        <td>{{$building->bldgasc}}</td>   
        <td>{{$building->bldguse}}</td>   
        <td>{{$building->offcnm}}</td>   
        <td>{{$building->prclkey}}</td>   
        <td>{{$building->yoc}}</td>   
        <td>{{$building->flrcount}}</td>   
        <td>{{$building->flrar}}</td>   
        <td>{{$building->consttyp}}</td>   
        <td>{{$building->elecyn}}</td>   
        <td>{{$building->bprmtyn}}</td>   
        <td>{{$building->bprmtno}}</td>   
        <td>{{$building->buildvflag}}</td>   
        <td>{{$building->drnkwtr}}</td>   
        <td>{{$building->wtrcons}}</td>   
        <td>{{$building->toilyn}}</td>   
        <td>{{$building->wwdischg}}</td>   
        <td>{{$building->swsegyn}}</td>   
        <td>{{$building->sngwoman}}</td>   
        <td>{{$building->hhcount}}</td>   
        <td>{{$building->hhpop}}</td>   
        <td>{{$building->gt60yr}}</td>   
        <td>{{$building->dsblppl}}</td>   
        <td>{{$building->datsrc}}</td>   
        <td>{{$building->txpyrname}}</td>   
        <td>{{$building->txpyrid}}</td>   
        <td>{{$building->due_name}}</td>   
</tr>
@endforeach
</tbody>
</table>