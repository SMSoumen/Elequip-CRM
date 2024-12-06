<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Quotation</title>
    <style>
        @page {
            margin: 0;
            size: A4;
        }

        @font-face {
            font-family: 'Open Sans';
            src: url('assets/admin/fonts/OpenSans-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            /* font-family: 'Open Sans', sans-serif; */
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            width: 21cm;
            height: 29.7cm;
        }

        .pdf_preview_container {
            /* border: 1px solid #d7d7d7; */
            padding: 5px;
            /* font-family: "Open Sans" */
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
        }

        .fs-16 {
            font-size: 16px !important;
        }

        .table-product-quot tr th {
            color: #000 !important;
            padding: 0;
            text-align: center;
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

        .p_font {
            padding: 0;
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
    </style>
</head>

<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; width:21cm; ">

    {{-- <div style="width:100%">
        <img src="{{ $head_img }}" alt="Elequip CRM" class="img-responsive"
                            style="width:99%;height: 113px;border-radius: 0px;">
    </div> --}}

    <div class="table pdf_preview_container" style="">
        <table class="table table-borderless my-0" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="" align="center">
                    <th colspan="4" class="text-center" style="border:none;" align="center">
                        <img src="{{ $head_img }}" alt="Elequip CRM" class="img-responsive"
                            style="width:99%;height: 113px;border-radius: 0px;margin-left: 0px;">
                    </th>
                </tr>
                <tr>
                    <th colspan="4" class="text-center" align="center">
                        <h5 class="fs-16" style="padding:0px;margin:2;"><b style="color:#000;">QUOTATION</b></h5>
                    </th>
                </tr>
            </thead>
        </table>
        <table class="table table_quot_top my-0" style="border-collapse: collapse;width: 100%;">
            <tbody style="">
                <tr style="border-top:1px solid black;border-right:1px solid #000;">
                    <td style="width: 10%;">To:</td>
                    <td style="width: 50%;">{{ $lead->company->company_name }}</td>
                    <td style="font-weight: 700;">Quot. Ref:</td>
                    <td colspan="2" style="font-weight: 700;border-right:1px solid #000;">
                        {{ $quotation->quot_ref_no }}<span class="pull-right">V -
                            {{ $quotation->quot_version }}</span></td>
                </tr>
                <tr>
                    <td rowspan="2" style="vertical-align: top;">Address</td>
                    <td rowspan="2" style="vertical-align: top;">{{ $lead->company->address }}</td>
                    <td style="font-weight: 700;">Date:</td>
                    <td colspan="2" style="font-weight: 700;border-right:1px solid #000;">
                        {{ \Carbon\Carbon::parse($lead->created_at)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td><span>&nbsp;</span></td>
                    <td colspan="2"><span>&nbsp;</span></td>
                    <!--<td style="">Due Date:</td>-->
                    <!--<td colspan="2" style="">12-05-2023</td>-->
                </tr>
                <tr>
                    <td style=" width: 12%;">Kind att:</td>
                    <td style="">{{ $lead->customer->customer_name }}</td>
                    <td style="width: 15%;">Enquiry No:</td>
                    <td colspan="2" style="width: 28%;border-right:1px solid #000;">
                        {{ $quotation->quot_user_ref_no }}</td>
                </tr>
                <tr>
                    <td style="">Phone:</td>
                    <td style="">{{ $lead->customer->mobile }}</td>
                    <td style="">Date:</td>
                    <td colspan="2" style="border-right:1px solid #000;">
                        {{ \Carbon\Carbon::parse($quotation->created_at)->format('d-m-Y') }}</td>
                </tr>

                <tr>
                    <td style="">Email:</td>
                    <td style="">{{ $lead->customer->email }}</td>
                    <td style="">Remarks:</td>
                    <td colspan="2" style="border-right:1px solid #000;">{{ $quotation->quot_remarks }}</td>
                </tr>
            </tbody>
        </table>
        <br>

        <table class="table table-product-quot" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border: 1px solid black;">
                    <th style="width: 3%;">SN.</th>
                    <th style="width: 51%">DESCRIPTION</th>
                    <th style="width: 8%">QTY</th>
                    <th style="width: 8%">UNIT</th>
                    <th style="width: 15%">RATE</th>
                    <th style="width: 15%">AMOUNT</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($quotaion_details as $i => $product)
                    <tr class="prod_row">
                        <td style="width: 3%;">{{ $i + 1 }}</td>

                        <td style="width: 50%;">
                            <p class="prod_head p_font" style="margin-top: 0px;">
                                {{ $product->quot_product_name }}
                                {{ $product->quot_product_code ? '(' . $product->quot_product_code . ')' : '' }}
                            </p>
                            <div class="p_font" style="">
                                @if ($product->quot_product_m_spec)
                                    {{ strip_tags(htmlspecialchars_decode($product->quot_product_m_spec)) }}
                                @endif
                            </div>

                            <div class="p_font">
                                @if ($product->quot_product_tech_spec)
                                    {{ strip_tags(htmlspecialchars_decode($product->quot_product_tech_spec)) }}
                                @endif
                            </div>

                        </td>
                        <td class="p_font" style="text-align: center;">
                            {{ $product->quot_product_qty }}
                        </td>
                        <td class="p_font" style="text-align: center;">
                            {{ $product->quot_product_unit ? ' ' . $product->quot_product_unit : ' Unit' }}
                        </td>
                        <td class="p_font" style="width: 14%; text-align:center">
                            <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                            {{ sprintf('%.2f', $product->quot_product_unit_price) }}
                        </td>
                        <td class="p_font" style="width: 14%; text-align:right">
                            <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                            {{ sprintf('%.2f', $product->quot_product_total_price) }}
                        </td>
                    </tr>
                @empty
                @endforelse

                <tr style="">
                    <td style=""></td>
                    <td style="" class="text-right p_font"><b>BASIC TOTAL</b> </td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style="" align="right">
                        <b>
                            <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                            {{ sprintf('%.2f', $quotation->quot_amount) }}
                        </b>

                    </td>
                </tr>
            </tbody>

        </table>

        <p class="mb-0"><b style="text-decoration:underline;margin-bottom:5px; display:block;color:#000">TERMS &amp;
                CONDITIONS:</b>
        </p>

        <table class="table table-borderless table_terms my-0" style="width: 100%; border-collapse: collapse;">
            <tbody>
                @if ($quot_terms)

                    @if ($quot_terms->term_discount)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">
                                Discount:
                            </td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_discount }}
                            </td>
                        </tr>
                    @endif

                    @if ($quot_terms->term_tax)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Tax:</td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_tax }}
                            </td>
                        </tr>
                    @endif
                    @if ($quot_terms->term_price)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Price:</td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_price }}
                            </td>
                        </tr>
                    @endif
                    @if ($quot_terms->term_payment)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Payment:</td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_payment }}
                            </td>
                        </tr>
                    @endif

                    @if ($quot_terms->term_dispatch)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Delivery:</td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_dispatch }}
                            </td>
                        </tr>
                    @endif

                    @if ($quot_terms->term_forwarding)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Freight :</td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_forwarding }}
                            </td>
                        </tr>
                    @endif
                    @if ($quot_terms->term_validity)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Validity: </td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_validity }}
                            </td>
                        </tr>
                    @endif

                    @if ($quot_terms->term_warranty)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Warranty: </td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_warranty }}
                            </td>
                        </tr>
                    @endif

                    @if ($quot_terms->term_note_1)
                        <tr style="border-left: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Note 1:</td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_note_1 }}
                            </td>
                        </tr>
                    @endif

                    @if ($quot_terms->term_note_2)
                        <tr
                            style="border-left: 1px solid black;border-bottom: 1px solid black; border-right: 1px solid black">
                            <td width="150px">Note 2:</td>
                            <td colspan="4" style="border-right:1px solid #000 !important;">
                                {{ $quot_terms->term_note_2 }}
                            </td>
                        </tr>
                    @endif

                @endif
            </tbody>

        </table>

        <table class="table table-borderless my-0" style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td colspan="5">
                        <p style="margin-bottom:0; margin-top:0;">We hope the offer is in line with your requirement,
                            for any technical or commercial
                            clarification please contact us. <br><b>Please mention our offer reference number for all
                                further communication.</b> </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right" align="right">
                        Created by: <b>Administrator <b>(9830084490)</b> </b></td>
                </tr>

                <tr>
                    <td colspan="5" class="text-center">This is a software generated document and signature is not
                        required for authentication</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>
