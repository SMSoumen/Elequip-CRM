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

        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            width: 21cm;
            height: 29.7cm;
        }

        .pdf_preview_container {
            /* border: 1px solid #d7d7d7; */
            padding: 5px;
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
        .p_font{
            padding: 0;
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
        <table class="table table_quot_top my-0" style="width: 100%; border-collapse: collapse;">
            <tbody style="">
                <tr style="border-top:1px solid black;border-right:1px solid #000;">
                    <td style="width: 10%;">To:</td>
                    <td style="width: 50%;">Demo CRM</td>
                    <td style="font-weight: 800;">Quot. Ref:</td>
                    <td colspan="2" style="font-weight: 800;border-right:1px solid #000;">G/CK/1446<span
                            class="pull-right">V - 1.2</span></td>
                </tr>
                <tr>
                    <td rowspan="2" style="vertical-align: top;">Address</td>
                    <td rowspan="2" style="vertical-align: top;">Salt Lake</td>
                    <td style="font-weight: 800;">Date:</td>
                    <td colspan="2" style="font-weight: 800;border-right:1px solid #000;">11-05-2023</td>
                </tr>
                <tr>
                    <td><span>&nbsp;</span></td>
                    <td colspan="2"><span>&nbsp;</span></td>
                    <!--<td style="">Due Date:</td>-->
                    <!--<td colspan="2" style="">12-05-2023</td>-->
                </tr>
                <tr>
                    <td style=" width: 12%;">Kind att:</td>
                    <td style="">Mr Gourav</td>
                    <td style="width: 15%;">Enquiry No:</td>
                    <td colspan="2" style="width: 28%;border-right:1px solid #000;">xcvbxcv</td>
                </tr>
                <tr>
                    <td style="">Phone:</td>
                    <td style="">9836830308</td>
                    <td style="">Date:</td>
                    <td colspan="2" style="border-right:1px solid #000;">11-05-2023</td>
                </tr>

                <tr>
                    <td style="">Email:</td>
                    <td style="">grv.sureka@live.com</td>
                    <td style="">Remarks:</td>
                    <td colspan="2" style="border-right:1px solid #000;">bxdfgsdfhdfhdfh</td>
                </tr>
            </tbody>
        </table>
        <br>

        <table class="table table-product-quot" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border: 1px solid black;">
                    <th>SN.</th>
                    <th>DESCRIPTION</th>
                    <th>QTY</th>
                    <th>UNIT</th>
                    <th>RATE</th>
                    <th>AMOUNT</th>
                </tr>
            </thead>
            <tbody>

                <tr class="prod_row">
                    <td style="width: 3%;">1</td>

                    <td style="width: 50%;">
                        <p class="prod_head p_font"></p>
                        <div class="p_font" style="padding:0;margin:0;">
                            Heavy duty, double ply duplex polyester slings for wide usage of lifting and material
                            handling. Conforms to ASME B 30.9 standards.
                        </div>

                        <div class="p_font">
                            <p>Capacity: 8 Ton<br>
                                Colour: Blue<br>
                                Width (mm): 200<br>
                                Length: 3 Meters</p>
                        </div>

                    </td>
                    <td class="p_font" style="width: 8%; text-align:center;">
                        1.00 </td>
                    <td class="p_font" style="width: 8%;text-align:center;">

                        Unit </td>
                    <td class="p_font" style="width: 12%; text-align:center">                        
                        <span style="font-family: DejaVu Sans, sans-serif;">₹</span> 4050.00
                    </td>
                    <td class="p_font" style="width: 12%; text-align:center">
                        <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                        4050.00
                    </td>
                </tr>
                <tr class="prod_row">
                    <td style="width: 3%;">1</td>

                    <td style="width: 56%;">
                        <p class="prod_head p_font"></p>
                        <div class="p_font" style="padding:0;margin:0;">
                            Heavy duty, double ply duplex polyester slings for wide usage of lifting and material
                            handling. Conforms to ASME B 30.9 standards.
                        </div>

                        <div class="p_font">
                            <p>Capacity: 8 Ton<br>
                                Colour: Blue<br>
                                Width (mm): 200<br>
                                Length: 3 Meters</p>
                        </div>

                    </td>
                    <td class="p_font" style="width: 8%; text-align:center;">
                        1.00 </td>
                    <td class="p_font" style="width: 8%;text-align:center;">

                        Unit </td>
                    <td class="p_font" style="width: 12%; text-align:center">                        
                        <span style="font-family: DejaVu Sans, sans-serif;">₹</span> 4050.00
                    </td>
                    <td class="p_font" style="width: 12%; text-align:center">
                        <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                        4050.00
                    </td>
                </tr>

                
                <tr style="">
                    <td style=""></td>
                    <td style="" class="text-right p_font"><b>BASIC TOTAL</b> </td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style=""></td>
                    <td style="" align="right">
                        <b>
                            <span style="font-family: DejaVu Sans, sans-serif;">₹</span>
                            12800.00 </b>

                    </td>
                </tr>
            </tbody>

        </table>

        <p class="mb-0"><b style="text-decoration:underline;margin-bottom:5px; display:block;color:#000">TERMS &amp;
                CONDITIONS:</b>
        </p>

        <table class="table table-borderless table_terms my-0" style="width: 100%; border-collapse: collapse;">


            <tbody>
                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px"></td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">
                    </td>
                </tr>
                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px">Tax:</td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">GST 18% EXTRA</td>
                </tr>
                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px">Price:</td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">
                        F.O.R Kolkata </td>
                </tr>

                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px">Payment:</td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">
                        100% against proforma invoice </td>
                </tr>
                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px">Delivery:</td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">
                        2 days of PO </td>
                </tr>

                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px">Freight :</td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">
                        2% Extra on basic price </td>
                </tr>

                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px">Validity: </td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">Offers remains valid for 30
                        days from the date of hereof.</td>
                </tr>

                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px">Warranty: </td>
                    <td colspan="4" style="border-right:1px solid #000 !important;">12 months from the date of
                        supply</td>
                </tr>

                <tr style="border-left: 1px solid black; border-right: 1px solid black">
                    <td width="150px"></td>
                    <td colspan="4" style="border-right:1px solid #000 !important;"></td>
                </tr>
                <tr style="border-left: 1px solid black;border-bottom: 1px solid black; border-right: 1px solid black">
                    <td width="150px"></td>
                    <td colspan="4" style="border-right:1px solid #000 !important;"></td>
                </tr>
            </tbody>

        </table>

        <table class="table table-borderless my-0" style="width: 100%; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td colspan="5">
                        <p style="margin-bottom:0; margin-top:0;">We hope the offer is in line with your requirement, for any technical or commercial
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
