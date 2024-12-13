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

    .pdf-download-container {
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
</style>

@php
    $quotation = session('quotation_data');
    $ref_no = $quotation['user']['code'] . '/';
    $ref_no .= $quotation['product']['brand']['brand_name']
        ? strtoupper(substr($quotation['product']['brand']['brand_name'], 0, 2))
        : strtoupper(substr($quotation['product']['product_name'], 0, 2));
    $ref_no .= '/' . sprintf('%04d', $quotation['lead']['id']);
    $total = 0;
    // echo "<pre>";
    //     print_r($quotation);
    // echo "</pre>";
    // die;
@endphp
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
                    <h5 class="fs-16"><b style="color:#000;">QUOTATION</b></h5>
                </th>
            </tr>
        </thead>
    </table>
    <table class="table table_quot_top my-0">
        <tbody style="">
            <tr style="border-top:1px solid black;border-right:1px solid #000;">
                <td style="width: 10%;">To:</td>
                <td style="width: 50%;">{{ $quotation['lead']['company']['company_name'] }}</td>
                <td style="font-weight: 700;">Quot. Ref:</td>
                <td colspan="2" style="font-weight: 700;border-right:1px solid #000;">
                    {{ $ref_no }}<span class="pull-right">V - 1.0</span></td>
            </tr>
            <tr>
                <td rowspan="2" style="vertical-align: top;">Address</td>
                <td rowspan="2" style="vertical-align: top;">{{ $quotation['lead']['company']['address'] }}</td>
                <td style="font-weight: 700;">Date:</td>
                <td colspan="2" style="font-weight: 700;border-right:1px solid #000;">
                    {{ \Carbon\Carbon::parse($quotation['lead']['created_at'])->format('d-m-Y') }}</td>
            </tr>
            <tr>
                <td><span>&nbsp;</span></td>
                <td colspan="2"><span>&nbsp;</span></td>
                <!--<td style="">Due Date:</td>-->
                <!--<td colspan="2" style="">12-05-2023</td>-->
            </tr>
            <tr>
                <td style=" width: 12%;">Kind att:</td>
                <td style="">{{ $quotation['lead']['customer']['customer_name'] }}</td>
                <td style="width: 15%;">Enquiry No:</td>
                <td colspan="2" style="width: 28%;border-right:1px solid #000;">
                    {{ $quotation['enquiry_ref'] }}
                </td>
            </tr>
            <tr>
                <td style="">Phone:</td>
                <td style="">{{ $quotation['lead']['customer']['mobile'] }}</td>
                <td style="">Date:</td>
                <td colspan="2" style="border-right:1px solid #000;">
                    {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                </td>
            </tr>

            <tr>
                <td style="">Email:</td>
                <td style="">{{ $quotation['lead']['customer']['email'] }}</td>
                <td style="">Remarks:</td>
                <td colspan="2" style="border-right:1px solid #000;">{{ $quotation['quotation_remarks'] }}</td>
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

            @forelse ($quotation['product_id'] as $i => $product_id)
                <tr class="prod_row">
                    <td>{{ $i + 1 }}</td>

                    <td>
                        <p class="prod_head p_font">
                            {{ $quotation['product_name'][$i] }}
                            {{ $quotation['product_code'][$i] ? '(' . $quotation['product_code'][$i] . ')' : '' }}
                        </p>
                        <div class="p_font" style="">
                            @if ($quotation['product_m_spec'][$i])
                                {{ strip_tags(htmlspecialchars_decode($quotation['product_m_spec'][$i])) }}
                            @endif
                        </div>

                        <div class="p_font">
                            @if ($quotation['product_tech_spec'][$i])
                                {{ strip_tags(htmlspecialchars_decode($quotation['product_tech_spec'][$i])) }}
                            @endif
                        </div>

                    </td>
                    <td class="p_font" style="text-align: center;">
                        {{ $quotation['qty'][$i] }}
                    </td>
                    <td class="p_font" style="text-align: center;">
                        {{ $quotation['product_unit'][$i] ? ' ' . $quotation['product_unit'][$i] : ' Unit' }}
                    </td>
                    <td class="p_font" style="width: 14%; text-align:center">
                        <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                        {{ sprintf('%.2f', $quotation['rate'][$i]) }}
                    </td>
                    <td class="p_font" style="width: 14%; text-align:right">
                        <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                        {{ sprintf('%.2f', $quotation['amount'][$i]) }}
                    </td>
                </tr>
                @php
                    $total += $quotation['amount'][$i];
                @endphp
            @empty
            @endforelse

            <tr style="">
                <td style=""></td>
                <td style="" class="text-right p_font"><b>BASIC TOTAL</b> </td>
                <td style=""></td>
                <td style=""></td>
                <td style=""></td>
                <td style="" class="text-right">
                    <b>
                        <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                        {{ sprintf('%.2f', $total) }}
                    </b>

                </td>
            </tr>
        </tbody>

    </table>

    <p class="mb-0"><b style="text-decoration:underline;margin-bottom:5px; display:block;color:#000">TERMS &amp;
            CONDITIONS:</b>
    </p>

    <table class="table table-borderless table_terms my-0">
        <tbody>
            @if ($quotation)

                @if ($quotation['discount'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">
                            Discount:
                        </td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['discount'] }}
                        </td>
                    </tr>
                @endif

                @if ($quotation['tax'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Tax:</td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">{{ $quotation['tax'] }}
                        </td>
                    </tr>
                @endif
                @if ($quotation['basis'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Price:</td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['basis'] }}
                        </td>
                    </tr>
                @endif
                @if ($quotation['payment'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Payment:</td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['payment'] }}
                        </td>
                    </tr>
                @endif

                @if ($quotation['delivery'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Delivery:</td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['delivery'] }}
                        </td>
                    </tr>
                @endif

                @if ($quotation['freight_forwarding'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Freight :</td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['freight_forwarding'] }}
                        </td>
                    </tr>
                @endif
                @if ($quotation['validity'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Validity: </td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['validity'] }}
                        </td>
                    </tr>
                @endif

                @if ($quotation['warranty'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Warranty: </td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['warranty'] }}
                        </td>
                    </tr>
                @endif

                @if ($quotation['note_1'])
                    <tr style="border-left: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Note 1:</td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['note_1'] }}
                        </td>
                    </tr>
                @endif

                @if ($quotation['note_2'])
                    <tr
                        style="border-left: 1px solid black;border-bottom: 1px solid black; border-right: 1px solid black">
                        <td width="150px">Note 2:</td>
                        <td colspan="4" style="border-right:1px solid #000 !important;">
                            {{ $quotation['note_2'] }}
                        </td>
                    </tr>
                @endif

            @endif
        </tbody>

    </table>

    <table class="table table-borderless my-0">
        <tbody>
            <tr>
                <td colspan="5">
                    <p style="margin-bottom:0;"> We hope the offer is in line with your requirement, for any
                        technical
                        or commercial clarification please contact us. <br><b>Please mention our offer reference
                            number
                            for all further communication.</b> </p>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="text-right">
                    Created by: <b>Administrator <b>(9830084490)</b> </b></td>
            </tr>

            <tr>
                <td colspan="5" class="text-center">This is a software generated document and signature is not
                    required for authentication</td>
            </tr>
        </tbody>
    </table>

    
</div>

@if ($lead->lead_stage_id == 2)
    <div class="pdf-download-container">
        <div class="">
            <form action="{{ route('admin.lead.quotation.create') }}" method="POST">@csrf
                <button type="submit" class="btn btn-success">Save & Next</button>
            </form>
        </div>
    </div>    
@endif
