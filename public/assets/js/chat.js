$(function() {
    "use strict";

    const ps5 = new PerfectScrollbar('#ChatBody', {
        useBothWheelAxes: true,
        suppressScrollX: true,
    });
    const ps6 = new PerfectScrollbar('.profile-details-main', {
        useBothWheelAxes: true,
        suppressScrollX: true,
    });
    const ps7 = new PerfectScrollbar('.main-chat-contacts-slider', {
        useBothWheelAxes: true,
        suppressScrollY: true,
    });
    const ps18 = new PerfectScrollbar('.main-chat-2', {
        useBothWheelAxes: true,
        suppressScrollX: true,
    });
});



$(document).ready(function() {
    // Function to update the chat messages
    function updateChat() {
        $.ajax({
            url: 'backend_endpoint.php', // Replace with your server-side endpoint to fetch chat messages
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Assuming the response is an array of chat messages, each containing 'user' and 'message' properties
                var chatMessages = response;
                var chatContent = '';
                for (var i = 0; i < chatMessages.length; i++) {
                    chatContent += '<div><strong>' + chatMessages[i].user + ':</strong> ' + chatMessages[i].message + '</div>';
                }
                $('#chat-messages').html(chatContent);
            },
            error: function() {
                console.log('Error fetching chat messages.');
            }
        });
    }

    // Initial update of chat messages
    updateChat();

    // Function to send a new message
    function sendMessage() {
        var user = 'User'; // Replace with the username of the sender or fetch dynamically
        var message = $('#message-input').val();

        if (message.trim() === '') {
            return; // Don't send an empty message
        }

        $.ajax({
            url: 'backend_endpoint.php', // Replace with your server-side endpoint to send chat messages
            type: 'POST',
            data: { user: user, message: message },
            success: function(response) {
                // Message sent successfully, update chat messages
                updateChat();
                // Clear the input field
                $('#message-input').val('');
            },
            error: function() {
                console.log('Error sending message.');
            }
        });
    }

    // Handle send button click event
    $('#send-button').on('click', function() {
        sendMessage();
    });

    // Handle pressing Enter key in the input field to send the message
    $('#message-input').on('keyup', function(event) {
        if (event.keyCode === 13) {
            sendMessage();
        }
    });

    // Periodically update chat messages (e.g., every 5 seconds)
    setInterval(function() {
        updateChat();
    }, 5000);
});
