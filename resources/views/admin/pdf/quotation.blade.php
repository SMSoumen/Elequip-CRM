<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attractive PDF</title>
    <link rel="stylesheet" href="styles.css">
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
</head>
<body>
    <div class="pdf-container">
        <header class="header">
            <h1>Attractive PDF Document</h1>
            <p>Generated using HTML and CSS</p>
        </header>
        <section class="content">
            <h2>About This Document</h2>
            <p>
                This is an example of a beautifully designed PDF document created using HTML and CSS. 
                The design includes a header, main content, and a table section, styled with a modern aesthetic.
            </p>
            <h2>Information Table</h2>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Notebook</td>
                        <td>High-quality notebook for notes.</td>
                        <td>$10</td>
                    </tr>
                    <tr>
                        <td>Pen</td>
                        <td>Set of smooth-writing pens.</td>
                        <td>$5</td>
                    </tr>
                    <tr>
                        <td>Planner</td>
                        <td>2024 planner with monthly and weekly views.</td>
                        <td>$15</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <footer class="footer">
            <p>Thank you for downloading this document.</p>
        </footer>
    </div>
</body>
</html>
