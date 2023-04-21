<!DOCTYPE html>
<html>

    <head>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td,
            th {
                border: 0.5px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #ddddde;
                border : 0.5px solid;
            }
            .text-right {
                text-align: right !important;
            }
            table#headerTable,
            table#headerTable th {
                border: none !important;
            }
        </style>
    </head>

    <body>
    <table id="headerTable">
        <th colspan="1">
        <div  style="display:inline-flex;  width:100%; height:auto;">
        <img src="{{'data:image/png;base64,'.base64_encode(file_get_contents(public_path('img/logo.png')))}}"   style="height:100%;width:150;">
        </th>   
        <th colspan="6" >   
            <div style="text-align:center;">
                    <h1 style="text-transform:uppercase;text-align:center">DHARAN MUNICIPALITY</h1>
                    <h2 style="text-transform:uppercase;text-align:center">GIS-BASED MUNICIPAL INFORMATION SYSTEM (GMIS)</h2>
        </th>
    </table>
       
        
        <h3>Building Tax Payment Status</h3>
        <table id="data-table" class="table table-bordered table-striped" width="100%" style="margin-top:50px">
            <tr>
              <th> Ward</th>
              <th> No. of buildings</th>
              <th> Not Due</th>
              <th> Due</th>
              <th> Data to be collected</th>
            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
            </tr>
           
        </table>
        <table id="data-table" class="table table-bordered table-striped" width="100%" style="margin-top:50px">
            <tr>
              <th> Ward</th>
              <th> No. of buildings</th>
              <th> No Due</th>
              <th> 1 Year</th>
              <th> 2 Year</th>
              <th> 3 Year</th>
              <th> 4 Year</th>
              <th> 5 Year+</th>
              <th> No Data</th>
            </tr>
            <tr>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
                <td>1</td>
            </tr>
           
        </table>
       
            
       

    </body>


</html>
