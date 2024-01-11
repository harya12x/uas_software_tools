<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <link rel="stylesheet" href="stylechat.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Chat Room</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                    </ul>
                </div>
                <div class="chat card-app" id="user-chat">
                    <div class="chat-header clearfix">
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="avatar">
                                </a>
                                <div class="chat-about">
                                    <h6 class="m-b-0"></h6>
                                    <small></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history">
                     
                    </div>
                    <div class="chat-message clearfix">
                        <div class="input-group mb-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-send"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter text here..." id="messageInput">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" onclick="postChatMessage()">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><script>
    var selectedUserID; 

    $(document).ready(function () {
    currentUserID = <?php echo $_SESSION['id_user']; ?>;
    console.log("Current User ID:", currentUserID);
    $("#user-chat").hide();

    <?php if(isset($_SESSION['username'])) { ?>

        $.ajax({
            url: "GetUsers.php",
            type: "get",
            dataType: "json",
            success: function (response) {
              
                response.forEach(function (user) {

                    if (parseInt(user.id_user) !== parseInt(currentUserID)) {
                        var listItem = '<li class="clearfix" data-user-id="' + user.id_user + '">' +
                            '<div class="about">' +
                            '<div class="name">' + user.nama_user + '</div>' +
                            '<div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>' +
                            '</div>' +
                            '</li>';
                        $(".chat-list").append(listItem);
                    }
                });

   
                $(".chat-list li").on("click", function () {
                    selectedUserID = $(this).data("user-id");
                    console.log("Selected User ID:", selectedUserID);

             
                    $("#selectedUserID").text("Selected User ID: " + selectedUserID);


                    displayChat(selectedUserID);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("GetUsers error:", textStatus, errorThrown);
            }
        });


    <?php } else { ?>
        window.location.href = 'index.php';
    <?php } ?>


});
function displayChat(selectedUserID) {
    $.ajax({
        url: "GetUserInfo.php",
        type: "get",
        dataType: "json",
        data: { id_user: selectedUserID },
        success: function (user) {
            console.log(user); 
            $(".chat-header img").attr("src", "https://bootdey.com/img/Content/avatar/avatar2.png");
            $(".chat-header h6").text(user.nama_user);

            // Perbarui last_seen di basis data saat pengguna membuka chat
            // updateLastSeen(currentUserID);
            
            // Tampilkan last_seen yang dinamis
            // displayLastSeen(selectedUserID);
            
            fetchChatHistory(selectedUserID);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("GetUserInfo error:", textStatus, errorThrown);
        }
    });
}


    
function fetchChatHistory(selectedUserID) {
    $.ajax({
        url: "GetChatHistory.php",
        type: "get",
        dataType: "json",
        data: { id_user: selectedUserID },
        success: function (chatHistory) {
            if (typeof chatHistory == 'object' && chatHistory !== null) {
                console.log(chatHistory);
            
                $(".chat-history").empty();
                chatHistory.forEach(function (chat) {
                    var isCurrentUser = String(chat.senderID) === String(currentUserID);
                    var messageClass = isCurrentUser ? 'alert-success' : 'alert-primary';
                    var senderName = isCurrentUser ? 'You' : chat.senderName;

                    var message = '<div class="alert ' + messageClass + ' message" role="alert">' +
                        '<span class="sender-name">' + senderName + ': </span>' +
                        '<p class="message-text">' + chat.message + '</p>' +
                        '<small class="text-muted">' + chat.timestamp + '</small>' +
                        '</div>';
                    $(".chat-history").append(message);
                });
                $("#user-chat").show();
            } else {
                console.log("Invalid JSON format received:", chatHistory);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("GetChatHistory error:", textStatus, errorThrown);
        }
    });
}

    function postChatMessage() {
    var messageInput = $(".chat-message input");
    var message = messageInput.val();

    if (selectedUserID && message.trim() !== "") {
        console.log("Sender ID:", currentUserID);
        console.log("Receiver ID:", selectedUserID);

        
        $.ajax({
            url: "PostChatMessage.php",
            type: "post",
            data: {
                senderID: currentUserID,
                receiverID: selectedUserID,
                message: message
            },
            success: function (response) {
                console.log("PostChatMessage success:", response);
                fetchChatHistory(selectedUserID);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("PostChatMessage error:", textStatus, errorThrown);
            }
        });

     
        messageInput.val("");
    }
}

setInterval(function () {

    fetchChatHistory(selectedUserID);
    }, 1000); // 5000 milliseconds = 5 seconds



</script>




</body>
</html>
