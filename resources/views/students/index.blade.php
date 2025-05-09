<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leerlingen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .message {
            text-align: left;
            color: red;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 10px;
            background-color: #ffe5e5;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ffcccc;
        }
        .add-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 1rem;
            margin-bottom: 20px;
        }
        .add-button:hover {
            background-color: #45a049;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button {
            border: none;
            background: none;
            cursor: pointer;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        @if (empty($students))
            <div class="message">
                <p>Momenteel geen leerlinggegevens beschikbaar.</p>
            </div>
        @else
            <div class="header">
                <h1>Overzicht Leerlingen</h1>
            </div>
        @endif
        <a href="#" class="add-button">➕ Voeg Leerling Toe</a>

        @if (!empty($students))
            <table>
                <thead>
                    <tr>
                        <th>Naam</th>
                        <th>Geboortedatum</th>
                        <th>Relatienummer</th>
                        <th>Adres</th>
                        <th>Mobiel</th>
                        <th>E-mail</th>
                        <th>Bewerken</th>
                        <th>Verwijderen</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->full_name }}</td>
                            <td>{{ $student->birth_date }}</td>
                            <td>{{ $student->relation_number }}</td>
                            <td>{{ $student->full_address }}</td>
                            <td>{{ $student->mobile }}</td>
                            <td>{{ $student->email }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button title="Bewerken">✏️</button>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button title="Verwijderen">🗑️</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>
</html>
