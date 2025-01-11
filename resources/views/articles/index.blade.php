<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Articles</title>


    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }

       
        .dataTables_wrapper .dataTables_paginate {
            text-align: center;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            margin: 0 2px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #0056b3;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

    </style>

   
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

</head>
<body>

    <h1>Articles List</h1>

    <!-- Display articles -->
    @if($articles->count())
        <table id="articlesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Source</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->category }}</td>
                        <td>{{ $article->source }}</td>
                        <td>{{ $article->content }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

       
        <div>
            {{ $articles->links() }}
        </div>
    @else
        <p>No articles available.</p>
    @endif

    <script>
        $(document).ready(function() {
            $('#articlesTable').DataTable({
                "paging": true,  
                "info": true,  
                "searching": true, 
                "ordering": true
            });
        });
    </script>

</body>
</html>
