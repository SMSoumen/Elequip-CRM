    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .pdf-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Header */
        .header {
            text-align: center;
            padding: 20px;
            border-bottom: 2px solid #f4f4f4;
        }

        .header h1 {
            font-size: 2em;
            color: #333;
            margin: 0;
        }

        .header p {
            font-size: 1.2em;
            color: #777;
        }

        /* Content Section */
        .content {
            padding: 20px;
        }

        .content h2 {
            color: #333;
            border-bottom: 2px solid #f4f4f4;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        .content p {
            font-size: 1.1em;
            line-height: 1.6;
            color: #555;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 1em;
        }

        table thead {
            background-color: #333;
            color: #fff;
        }

        table th,
        table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        table tbody tr:hover {
            background-color: #e9e9ff;
        }

        /* Footer */
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 0.9em;
            color: #777;
            margin-top: 20px;
            border-top: 2px solid #f4f4f4;
        }

    </style>
    <div class="row float-right">
        <a href="{{route('admin.lead.quotation.edit',$lead->id)}}"><button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button></a>
    </div>
    <div class="pdf-container">
        <header class="header">
            <h1>ELEQUIP TOOLS PRIVATE LIMITED</h1>
            <p>Office: 19 Pollock Street, 2nd Floor, Kolkata - 700001, West Bengal</p>
            <table class="table table-borderless">
                    <tr>
                        <td><p>Phone:</span> (033) 22351792/2400</p></td>
                        <td><p><span>Email:</span> contact@ehoists.in</p></td>
                        <td><p><span>GST:</span> 19AAACE8804D1ZT</p></td>
                    </tr>           
            </table>
        </header>
            <h5 class="text-center">QUOTATION</h5>
            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; margin-top: 20px; border: 1px solid black;">
                
                <tr>
                    <td style="width: 10%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>To:</strong></p>
                    </td>
                    <td style="width:45%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"> Dhunseri Poly Films Pvt Ltd.</p>
                    </td>
                    <td style="width: 20%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Quot. Ref:</strong></p>
                        
                    </td>
                    <td style="width: 25%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Quot. Ref:</strong> V - 1.0</p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Address:</strong></p>
                    </td>
                    <td style="width:45%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;">  A26-A27, Panagarh Industrial Park, Kanksa, Panagarh, Distt. Paschim Bardhman-713148</p>
                    </td>
                    <td style="width: 20%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Date:</strong></p>
                        
                    </td>
                    <td style="width: 25%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>{{date('d-m-Y')}}</strong></p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Kind att:</strong></p>
                    </td>
                    <td style="width:45%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;">  Devesh Mishra </p>
                    </td>
                    <td style="width: 20%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Enquiry No:</strong></p>
                        
                    </td>
                    <td style="width: 25%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>GOODS123</strong></p>
                    </td>
                </tr>
                
                <tr>
                    <td style="width: 10%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Phone:</strong></p>
                    </td>
                    <td style="width: 45%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;">7477787121</p>
                    </td>
                    <td style="width: 20%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Date:</strong></p>
                    </td>
                    <td style="width: 25%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>{{date('d-m-Y')}}</strong></p>
                    </td>
                </tr>
                
                <tr>
                    <td style="width: 10%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Email:</strong></p>
                    </td>
                    <td style="width: 45%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;">Devesh.mishra@aspetindia.com</p>
                    </td>
                    <td style="width: 20%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Remarks:</strong></p>
                    </td>
                    <td style="width: 25%; padding: 8px; border: 1px solid black;">
                        <p style="margin: 0;"><strong>Good</strong></p>
                    </td>
                </tr>      
            </table>

            <table style="width: 100%; border: 1px solid black; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr>
                        <th style="border: 1px solid black; padding: 8px;">SN.</th>
                        <th style="border: 1px solid black; padding: 8px;">DESCRIPTION</th>
                        <th style="border: 1px solid black; padding: 8px;">QTY</th>
                        <th style="border: 1px solid black; padding: 8px;">UNIT</th>
                        <th style="border: 1px solid black; padding: 8px;">RATE</th>
                        <th style="border: 1px solid black; padding: 8px;">AMOUNT</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1 -->
                    <tr style="font-size: 15px; text-align: center;">
                        <td style="border: 1px solid black; padding: 8px;">1</td>
                        <td style="border: 1px solid black; padding: 8px; text-align: left;">
                            CC-Spares (Spares/Crane)<br>
                            a<br> Crane Model - <br> Part name -
                        </td>
                        <td style="border: 1px solid black; padding: 8px;">1.00</td>
                        <td style="border: 1px solid black; padding: 8px;">Nos.</td>
                        <td style="border: 1px solid black; padding: 8px;">₹ 1.00</td>
                        <td style="border: 1px solid black; padding: 8px;">₹ 1.00</td>
                    </tr>
                    <!-- Row 2 -->
                    <tr style="font-size: 15px; text-align: center;">
                        <td style="border: 1px solid black; padding: 8px;">2</td>
                        <td style="border: 1px solid black; padding: 8px; text-align: left;">
                            Chain Hoist-Spares (Spares/CEH)<br>
                            a <br> Model - <br> Part name -
                        </td>
                        <td style="border: 1px solid black; padding: 8px;">1.00</td>
                        <td style="border: 1px solid black; padding: 8px;">Nos.</td>
                        <td style="border: 1px solid black; padding: 8px;">₹ 1.00</td>
                        <td style="border: 1px solid black; padding: 8px;">₹ 1.00</td>
                    </tr>
                    <!-- Row Totals -->
                    <tr style="font-size: 15px; text-align: center;">
                        <td style="border: 1px solid black; padding: 4px;"></td>
                        <td style="border: 1px solid black; padding: 4px; text-align: right;">
                            <p style="font-size: 15px; font-weight: 600;">BASIC TOTAL</p>        
                        </td>
                        <td style="border: 1px solid black; padding: 4px;"></td>
                        <td style="border: 1px solid black; padding: 4px;"></td>
                        <td style="border: 1px solid black; padding: 4px;"></td>
                        <td style="border: 1px solid black; padding: 4px;">2.00</td>
                    </tr> 
                </tbody>
            </table>

            <div>
                <p>TERMS & CONDITIONS:</p>
            </div>
    
            <table style="width: 100%; border: 1px solid black; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px;">

                <tr>
                    <td style="width: 20%; padding: 8px;">Discount:</td>
                    <td style="padding: 8px; ">10</td>
                </tr>
                <tr>
                    <td style="padding: 8px; ">Tax:</td>
                    <td style="padding: 8px; ">GST 18% EXTRA</td>
                </tr>
                <tr>
                    <td style="padding: 8px;">Price:</td>
                    <td style="padding: 8px;">F.O.R Kolkata</td>
                </tr>
                <tr>
                    <td style="padding: 8px; ">Payment:</td>
                    <td style="padding: 8px; ">100% against proforma invoice</td>
                </tr>
                <tr>
                    <td style="padding: 8px; ">Delivery:</td>
                    <td style="padding: 8px; ">2 days of PO</td>
                </tr>
                <tr>
                    <td style="padding: 8px; ">Freight:</td>
                    <td style="padding: 8px; ">2% Extra on basic price</td>
                </tr>
                <tr>
                    <td style="padding: 8px; ">Validity:</td>
                    <td style="padding: 8px; ">Offers remain valid for 30 days from the date of hereof.</td>
                </tr>
                <tr>
                    <td style="padding: 8px; ">Warranty:</td>
                    <td style="padding: 8px; ">12 months from the date of supply</td>
                </tr>
            </table>
            <p style="margin-top: 20px; font-family: Arial, sans-serif; font-size: 15px;">
                We hope the offer is in line with your requirement, for any technical or commercial clarification please contact us.<br>
                <strong>Please mention our offer reference number for all further communication.</strong>
            </p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; text-align: right;">
                Created by: <strong>Administrator (9830084490)</strong><br>
            </p>
            <p style="font-family: Arial, sans-serif; font-size: 15px; text-align: center;">
                <span style="font-size: 15px;">This is a software-generated document and signature is not required for authentication.</span>
            </p>

            <!--=============================================================-->

            <div class="row">
                @foreach($quotations as $quotation)
                <a href="{{route('admin.quotaion.pdf',$quotation->id)}}"><h5 class="badge bg-primary m-3">V - {{$quotation->quot_version}}</h5></a>
                @endforeach
            </div>
    </div>