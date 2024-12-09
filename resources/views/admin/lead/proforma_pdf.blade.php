@if($po_details)
    <style>
        .pdf_preview_container {
            border: 1px solid #d7d7d7;
            padding: 10px;
            font-family: "Open Sans"
        }

        .pdf_preview_container table thead {
            background-color: #fff;
        }

        .table_quot_top,
        .table_quot_top tr,
        .table_quot_top th,
        .table_quot_top td {
            border: 1px solid #000 !important;
        }

        .table td {
            padding: 4px 10px;
            font-size: 15px;
            line-height: 1;
        }

        .fs-16 {
            font-size: 16px !important;
        }

        .table-product-quot tr th {
            color: #000 !important;
            padding: 0;
            text-align: center;
            font-size: 15px;
        }

        .table-product-quot,
        .table-product-quot tr,
        .table-product-quot th,
        .table-product-quot td {
            border: 1px solid #000 !important;
        }

        .table_terms {
            border: 1px solid #000 !important;
        }

        .table_terms td {
            line-height: 1;
        }

        .pdf-download-container {
            border: 1px solid #d7d7d7;
            padding: 10px;
        }

        .pull-right {
            float: right;
        }

        .prod_head {
            font-weight: 700 !important;
            color: #082173 !important;
            margin-bottom: 0;
            text-decoration: underline;
        }
        .p_font{
            font-size: 15px;
            line-height: 24px !important;
        }
    </style>
    <div class="row float-right">
        <a href="{{ route('admin.lead.proforma.edit', $proforma->id) }}"><button type="button" class="btn btn-primary"><i
                    class="fas fa-edit"></i></button></a>
    </div>

    <div class="table pdf_preview_container" style="width:21cm;">
        <table class="table table-borderless my-0">
            <thead>
                <tr>
                    <th colspan="4" class="text-center" style="border:none;">
                        <img src="{{ asset(asset_path('assets/admin/img/quotation-header.jpg')) }}" alt=""
                            class="img-responsive" style="width:99%;height: 113px;border-radius: 0px;">
                    </th>
                </tr>
                <tr>
                    <th colspan="4" class="text-center p-1">
                        <h5 class="fs-16"><b style="color:#000;">PROFORMA</b></h5>
                    </th>
                </tr>
            </thead>
        </table>
        <table class="table table_quot_top my-0">
            <tbody style="">
                <tr style="border-top:1px solid black;border-right:1px solid #000;">
                    <td style="width: 10%;">To:</td>
                    <td style="width: 50%;">{{ $lead->company->company_name }}</td>
                    <td style="font-weight: 700;">Doc No:</td>
                    <td colspan="2" style="font-weight: 700;border-right:1px solid #000;">
                        OA/{{ $po_details->po_refer_no }}
                    </td>
                </tr>
                <tr>
                    <td rowspan="2" style="vertical-align: top;">Address</td>
                    <td rowspan="2" style="vertical-align: top;">{{ $lead->company->address }}</td>
                    <td style="font-weight: 700;">Date:</td>
                    <td colspan="2" style="font-weight: 700;border-right:1px solid #000;">
                        {{ \Carbon\Carbon::parse($proforma->created_at)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td style="border-right: 1px solid black;">Order No:</td>
                    <td colspan="2" style="border-right: 1px solid black;">{{ $po_details->po_order_no }}</td>
                </tr>
                <tr>
                    <td style=" width: 12%;">GST No:</td>
                    <td style="">{{ $lead->company->gst }}</td>
                    <td style="width: 15%;">Order Date:</td>
                    <td colspan="2" style="width: 28%;border-right:1px solid #000;">
                        {{ $po_details->po_order_date }}</td>
                </tr>
                <tr>
                    <td style="">Phone:</td>
                    <td style="">{{ $lead->customer->mobile }}</td>
                    <td style="">Dispatch:</td>
                    <td colspan="2" style="border-right:1px solid #000;">
                        {{ $proforma->proforma_dispatch }}
                    </td>
                </tr>

                <tr>
                    <td style="">Email:</td>
                    <td style="">{{ $lead->customer->email }}</td>
                    <td style="">Remarks:</td>
                    <td colspan="2" style="border-right:1px solid #000;">{{ $proforma->proforma_remarks }}</td>
                </tr>
            </tbody>
        </table>
        <br>

        <table class="table table-product-quot">
            <thead>
                <tr style="border: 1px solid black;">
                    <th style="width: 3%">SN.</th>
                    <th style="width: 51%">DESCRIPTION</th>
                    <th style="width: 8%">QTY</th>
                    <th style="width: 8%">UNIT</th>
                    <th style="width: 15%">RATE</th>
                    <th style="width: 15%">AMOUNT</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total = 0.0;
                @endphp
                @forelse ($proforma->proforma_details as $i => $product)
                    <tr class="prod_row">
                        <td>{{ $i + 1 }}</td>

                        <td>
                            <p class="prod_head p_font">
                                {{ $product->proforma_product_name }}
                                {{ $product->proforma_product_code ? '(' . $product->proforma_product_code . ')' : '' }}
                            </p>
                            <div class="p_font" style="">
                                @if ($product->proforma_product_spec)
                                    {{ strip_tags(htmlspecialchars_decode($product->proforma_product_spec)) }}
                                @endif
                            </div>
                        </td>
                        <td class="p_font" style="text-align: center;">
                            {{ $product->proforma_product_qty }}
                        </td>
                        <td class="p_font" style="text-align: center;">
                            {{ $product->proforma_product_unit ? ' ' . $product->proforma_product_unit : ' Unit' }}
                        </td>
                        <td class="p_font" style="width: 14%; text-align:center">
                            <span style="font-family: DejaVu Sans, sans-serif;">₹</span>{{ sprintf('%.2f', $product->proforma_product_price) }}
                        </td>
                        <td class="p_font" style="width: 14%; text-align:right">
                            <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                            {{ sprintf('%.2f', $product->proforma_product_price * $product->proforma_product_qty) }}
                        </td>
                    </tr>
                    @php
                        $ts = sprintf('%.2f', $product->proforma_product_price * $product->proforma_product_qty);
                        $total += $ts;
                        $ts = null;
                    @endphp
                @empty
                @endforelse

                <tr style="">
                    <td style=""></td>
                    <td style="" class="text-right"><b>BASIC TOTAL</b> </td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style="" class="text-right">
                        <b>
                            <span style="font-family: DejaVu Sans, sans-serif;">₹</span>{{ sprintf('%.2f', $total) }}
                        </b>
                    </td>
                </tr>

                @php
                    $tax_percent = $po_details->po_tax_percent;
                @endphp

                @if ($proforma->proforma_gst_type == 1)
                    @php
                        $cgst = $total * ($tax_percent / 200);
                        $sgst = $total * ($tax_percent / 200);
                        $total_with_tax = $total + $total * ($tax_percent / 100);
                    @endphp
                    <tr style="border-bottom: 2px solid black;">
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;font-weight:700;" class="text-right">CGST % </td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;font-weight:700;" align="center">
                            <?= $tax_percent / 2 ?>%</td>
                        <td style="border-right: 1px solid black;font-weight:700;" class="text-right"><span style="font-family: DejaVu Sans, sans-serif;">₹</span><?= sprintf('%.2f', $cgst) ?></td>
                    </tr>
                    <tr style="border-bottom: 2px solid black;">
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;font-weight:700;" class="text-right">SGST % </td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;font-weight:700;" align="center">
                            <?= $tax_percent / 2 ?>%</td>

                        <!-- <td style="border-right: 1px solid black;"></td> -->
                        <td style="border-right: 1px solid black;font-weight:700;" class="text-right"><span style="font-family: DejaVu Sans, sans-serif;">₹</span><?= sprintf('%.2f', $sgst) ?></td>
                    </tr>
                @else
                    @php
                        $igst = $total * ($tax_percent / 100);
                        $total_with_tax = $total + $total * ($tax_percent / 100);
                    @endphp
                    <tr style="border-bottom: 2px solid black;">
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;font-weight:700;" class="text-right">IGST % </td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                        <td style="border-right: 1px solid black;border-left: 2px solid black;font-weight:700;" align="center">
                            <?= $tax_percent ?>%</td>
                        <!-- <td style="border-right: 1px solid black;"></td> -->
                        <td style="border-right: 1px solid black;font-weight:700;" class="text-right"><span style="font-family: DejaVu Sans, sans-serif;">₹</span><?= sprintf('%.2f', $igst) ?></td>
                    </tr>
                @endif
                <tr style="border-bottom: 2px solid black;">
                    <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                    <td style="border-right: 1px solid black; font-weight:700;" class="text-right">TOTAL PAYABLE </td>
                    <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                    <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                    <td style="border-right: 1px solid black;border-left: 2px solid black;"></td>
                    <!-- <td style="border-right: 1px solid black;"></td> -->
                    <td style="border-right: 1px solid black;font-weight:700;" class="text-right"><span style="font-family: DejaVu Sans, sans-serif;">₹</span><?= sprintf('%.2f', $total_with_tax) ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="5">
                        <span>Amount in words (Rupees): </span>{{ numberTowords($total_with_tax) }}<span> only</span>
                    </td>
                </tr>

            </tbody>

        </table>


        <table style="width:100%" class="table table-borderless">
            <tbody>
                <td colspan="2"></td>
                <tr>
                    <td colspan="2" class="text-left">
                        <p style="text-decoration:underline;margin-bottom:0;"><b>Our Bank Details:</b></p>
                    </td>
                </tr>

                <tr>
                    <td>Bank: </td>
                    <td>PUNJAB NATIONAL BANK (Current A/c), Branch – Brabourne Road, Kolkata 700001</td>
                </tr>
                <tr>
                    <td>Account No: </td>
                    <td>010000-55000-00276</td>
                </tr>
                <tr>
                    <td>IFSC Code: </td>
                    <td>PUNB0010000</td>
                </tr>
                <td colspan="2"></td>
                <tr>
                    <td>Bank: </td>
                    <td>ICICI BANK LIMITED (Current A/C), Branch - R.N Mukherjee Road, Kolkata 700001</td>
                </tr>
                <tr>
                    <td>Account No: </td>
                    <td>000605034380</td>
                </tr>
                <tr>
                    <td>IFSC Code: </td>
                    <td>ICIC0000006</td>
                </tr>

                <td colspan="2"></td>

                <tr>
                    <td colspan="2" class="text-right">

                        <?php
                        if ($lead->admin->name) {
                            echo 'Created by: ';
                            echo '<b>' . $lead->admin->name . ' ';
                            echo '<b>(' . $lead->admin->phone . ')</b>';
                        }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class="text-center">This is a software generated document and signature is not
                        required for authentication</td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="pdf-download-container">
        <div class="">
            <a class="p-1 badge bg-primary" href="{{ route('admin.proforma.pdf', $lead->id) }}">
                <h6 class="mb-0"><i class="fas fa-download"></i> Download Proforma</h6>
            </a>
        </div>
    </div>

    @endif
