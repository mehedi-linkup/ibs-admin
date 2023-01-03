@extends('layouts.master')
@section('title', 'Product SubTotal')
@push('css')
    <style>
        .table th{
            font-size: 13px; 
        }
    </style>
@endpush
@section('main-content')
<main id="root">
    <div class="container-fluid">
        <div class="heading-title p-2 my-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Home</a> > Product Search</span>
        </div>
        <div class="card my-3">
            <div class="card-header">
                <form @submit.prevent="getProducts">
                    <div class="form-group row mx-auto">
                        <label class="col-md-1 px-0">Form Date</label>
                        <div class="col-md-3">
                            <input type="date"  v-model="filter.dateFrom" class="form-control mb-0">
                        </div>
                        <label class="col-md-1">To Date</label>
                        <div class="col-md-3">
                            <input type="date"  v-model="filter.dateTo" class="form-control mb-0">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm col-md-1">Search</button>
                    </div>
                </form>
            </div>
            <div v-if="products.length > 0" class="text-end">
                <button class="btn btn-dark btn-sm my-2" type="button" onclick="printById('print__container')">Print Report</button>
            </div>
            <div class="card-body table-card-body table-responsive" v-if="products.length > 0" id="print__container">
                <table class="table table-bordered table-hover">
                    <thead class="text-center bg-light">
                        <tr>
                            <th>SL</th>
                            <th>C/P</th>
                            <th>Buyer</th>
                            <th>Season</th>
                            <th>Dept.</th>
                            <th>Style Number/Name</th>
                            <th>Product Description</th>
                            <th>Base/ Top up/ Reprat</th>
                            <th>FTY</th>
                            <th>L/C</th>
                            <th>SMV</th>
                            <th>EFF%</th>
                            <th>FOB</th>
                            <th>TOD</th>
                            <th>Quantity</th>
                            <th>CM</th>
                            <th>VALUE</th>
                            <th>TOTAL SMH</th>
                            <th>SMH EFF</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-for="(item, i) in products" :key="i">
                            <td>@{{ i + 1 }}</td>
                            <td>@{{ item.cp }}</td>
                            <td>@{{ item.buyer }}</td>
                            <td>@{{ item.season }}</td>
                            <td>@{{ item.department }}</td>
                            <td>@{{ item.style_no_or_name }}</td>
                            <td>@{{ item.description }}</td>
                            <td>@{{ item.base_top_up }}</td>
                            <td>@{{ item.fty }}</td>
                            <td>@{{ item.lc }}</td>
                            <td>@{{ item.smv }}</td>
                            <td>@{{ item.eff }}</td>
                            <td>@{{ item.fob }}</td>
                            <td>@{{ item.tod }}</td>
                            <td>@{{ item.quantity }}</td>
                            <td>@{{ parseFloat((item.smv / (item.eff/100))* 0.045 * 12).toFixed(2) }}</td>
                            <td>@{{ parseFloat(item.fob * item.quantity).toFixed(2) }}</td>
                            <td>@{{ parseFloat(item.smv * item.quantity / 60).toFixed(2) }}</td>
                            <td>@{{ parseFloat((item.smv * item.quantity / 60) / (item.eff/100)).toFixed(2)  }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection
@push('js')
    <script>
        const app = new Vue({
            el: '#root',
            data: {
                filter: {
                    dateFrom: moment().format("YYYY-MM-DD"),
                    dateTo: moment().format("YYYY-MM-DD"),
                },
                products: [],
            },
            
            methods: {
                getProducts() {
                    axios.post('/get_product_search', this.filter)
                    .then(res => {
                        this.products = res.data;
                    })
                }
            }
        });

        function printById(id)
        {
            var mywindow = window.open('', 'PRINT');
    
            mywindow.document.write(`
            <html><head><title>Product Report</title>
            <style>
                body {font-family: sans-serif;}
                table, tr, td,th {border: 1px solid black; padding: 5px 8px; font-size: 14px;}
                table {border-collapse: collapse}
                .font-weight-bold {font-weight: bold}
                .text-center {text-align: center}
                .vertical-align-top {vertical-align: top}
                .text-underline {text-decoration: underline}
                .text-uppercase {text-transform: uppercase}
                .label {width: 115px; display: inline-block; font-weight: bold;}
                .pt__title {display:inline-block; margin-right: 15px; font-weight: bold}
                .pt__box {height: 15px; width: 16px; border: 1px solid; display: inline-block; position: relative; top: 3px; margin-left: 10px; margin-right: 15px;}
                .sign__wrapper {display: flex; margin-top: 70px}
                .sign {width: 33.33%; text-align: center; font-weight: bold; text-decoration: overline}
                .attachment_page {page-break-before: always}
                .attachment__image {object-fit: contain; max-height: 180px}
            </style>
            `);
    
            mywindow.document.write('</head><body onload="loadHandler()">');
            mywindow.document.write(document.getElementById(id).innerHTML);
            mywindow.document.write('</body></html>');
    
            var is_chrome = Boolean(window.chrome);
            if (is_chrome) {
                mywindow.document.execCommand('print');
                mywindow.close();
            } else {
                mywindow.document.close(); // necessary for IE >= 10
                mywindow.focus(); // necessary for IE >= 10*/
    
                mywindow.print();
                mywindow.close();
            }
        return true;
        }
    </script>
@endpush