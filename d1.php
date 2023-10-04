<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/display_table.css">
    <!-- <script defer src="js/app.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function() {
    var currentSlide = 1;

    function updateContent(slideNumber) {
        $.ajax({
            url: 'get_project_data.php?timestamp=' + new Date().getTime(),
            method: 'GET',
            data: {
                slideNumber: slideNumber
            },
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#table-body');

                tableBody.empty();

                $.each(data, function(index, project) {
                    tableBody.append(
                        '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + project.NameOfProject + '</td>' +
                        '<td>' + project.Date + '</td>' +
                        '<td>' + project.CandidateCount + '</td>' +
                        '</tr>'
                    );
                });
            },
            error: function() {
                console.log('Error fetching data from the server.');
            }
        });

        $.ajax({
            url: 'get_project_data.php?timestamp=' + new Date().getTime(),
            method: 'GET',
            data: {
                slideNumber: slideNumber
            },
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#table-body');

                tableBody.empty();

                $.each(data, function(index, project) {
                    tableBody.append(
                        '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + project.NameOfProject + '</td>' +
                        '<td>' + project.Date + '</td>' +
                        '<td>' + project.CandidateCount + '</td>' +
                        '</tr>'
                    );
                });
            },
            error: function() {
                console.log('Error fetching data from the server.');
            }
        });

        $.ajax({
            url: 'get_project_data.php?timestamp=' + new Date().getTime(),
            method: 'GET',
            data: {
                slideNumber: slideNumber
            },
            dataType: 'json',
            success: function(data) {
                var tableBody = $('#table-body');

                tableBody.empty();

                $.each(data, function(index, project) {
                    tableBody.append(
                        '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + project.NameOfProject + '</td>' +
                        '<td>' + project.Date + '</td>' +
                        '<td>' + project.CandidateCount + '</td>' +
                        '</tr>'
                    );
                });
            },
            error: function() {
                console.log('Error fetching data from the server.');
            }
        });
    }

    function updateTable(data) {
        // Update your table with real-time data
        // For example, you can append new rows or update existing rows with the incoming data
        // Here's a basic example of how to append new rows to the table
        var tableBody = $('#table-body');
        
        $.each(data, function(index, project) {
            tableBody.append(
                '<tr>' +
                '<td>' + (index + 1) + '</td>' +
                '<td>' + project.NameOfProject + '</td>' +
                '<td>' + project.Date + '</td>' +
                '<td>' + project.CandidateCount + '</td>' +
                '</tr>'
            );
        });
    }

    updateContent(currentSlide);

    $('#prev').click(function() {
        if (currentSlide > 1) {
            currentSlide--;
            updateContent(currentSlide);
        }
    });

    $('#next').click(function() {
        currentSlide++;
        updateContent(currentSlide);
    });

    // WebSocket connection for real-time updates
    var socket = new WebSocket('ws://localhost:8080/websocket');

    socket.onopen = function(event) {
    // Handle a successful WebSocket connection
    console.log('WebSocket connection is open:', event);
    
    // You can perform any additional actions here if needed
    // For example, you might want to show a message to the user
    // indicating that the connection is established.
};

    socket.onmessage = function(event) {
        // Handle real-time updates from the WebSocket server
        var data = JSON.parse(event.data);
        // Update your dashboard with the new data
        updateTable(data);
    };

    socket.onclose = function(event) {
        // Handle WebSocket closure or errors
        console.error('WebSocket closed:', event);
    };
    socket.onerror = function(event) {
    // Handle WebSocket errors
    console.error('WebSocket error:', event);
    
    // You can implement error handling logic here if needed
};

});

    </script>
</head>
<body>
    <div class="slider">
        <div class="list">
            <div class="item">
                <main class="table">
                    <section class="table__header">
                        <h1 style="color: white; font-size: 25px;">Go Live Status</h1>
                    </section>
                    <section class="table__body">
                        <table>
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Project Name</th>
                                    <th>Application Start Date</th>
                                    <th>Candidate Count</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                                <!-- Table content will be populated dynamically here -->
                            </tbody>
                        </table>
                    </section>
                </main>
            </div>
        
            <div class="buttons">
                <button id="prev"><</button>
                <button id="next">></button>
            </div>
            <ul class="dots">
                <li class="active"></li>
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul>
        </div>
    </div>
</body>
</html>
