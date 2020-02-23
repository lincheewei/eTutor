<?php
    require "session.php";
    require "utility.php";
    require "MessageRepository.php";

    checkEntity(array("student", "tutor"));

    if(!empty($_GET['submit'])) {
        if($_GET['submit'] === 'Delete') {            
            try {
                if(!empty($_GET['id'])){
                    $messageRepo = new MessageRepository();
                    $messageRepo->recallMessage($_GET['id'], getUserEmail());                       
                } else {
                    throw new Exception("Invalid message ID.");
                }
            }
            catch(Exception $ex){
                $errorMessages = array(
                    "message" => $ex->getMessage()
                );
            }
            finally {
                $_POST['recipient'] = $_GET['recipient'];
            }
        }
    }

    if(!empty($_POST['submit'])){
        if($_POST['submit'] === 'Send'){
            try {
                $messageRepo = new MessageRepository();
                switch(getUserEntity()){
                    case 'student':
                        if($messageRepo->sendMessage(getUserEmail(), $_POST['recipient'], $_POST['message'])){
                            $successMessage = "Message has been sent.";
                        }           
                        break;

                    case 'tutor':
                        if($messageRepo->sendMessage(getUserEmail(), $_POST['recipient'], $_POST['message'])){
                            $successMessage = "Message has been sent.";
                        }           
                        break;
                }                        
            }
            catch(Exception $ex){
                $errorMessages = array(
                    "message" => $ex->getMessage()
                );
            }
        }
    } 

?>

<!DOCTYPE html>
<html>
    <?php Utility::loadHeader("Messaging", array("bootstrap.min.css")); ?>

    <body>
        <?php Utility::loadNavBar(); ?>
        <main class="container">
            <div class="row">
                <div class="col-md-9 col-xs-12">
                    <div class="py-4 bg-info text-white" id="chatbox">
                        <?php
                            try {
                                if(!empty($_POST['recipient'])){
                                    if(empty($messageRepo)){
                                        $messageRepo = new MessageRepository();
                                    }
                                    $chat = $messageRepo->getMessage(getUserEmail(), $_POST['recipient']);
                                    if($chat['rowCount'] > 0){
                                        foreach($chat['data'] as $value){                                            
                                            $date = new DateTime($value['dateSend']);
                                            echo '<p class="text-center mb-0">' . $date->format("d-m-y h:i:s") . '</p>';
                                            if($value['senderEmail'] === getUserEmail()){
                                                $message = str_replace("<", "&lt", $value['message']);
                                                $message = str_replace(">", "&gt", $message);
                                                echo "<div><p class='mr-4 text-right p-3 bg-success wrap-text' style='margin-left : 120px'><a class='deleteLink' href='" . $_SERVER['PHP_SELF'] . "?submit=Delete&id=" . $value['id'] . "&recipient=" . $_POST['recipient'] . "'><span style='font-size:10px; float:left;background-color:white;padding: 5px'>&#10006;</span></a>" . $message . "</p></div>";
                                            } else {
                                                $message = str_replace("<", "&lt", $value['message']);
                                                $message = str_replace(">", "&gt", $message);
                                                echo "<p class='ml-4 text-justify p-3 bg-secondary'  style='margin-right : 120px'>" . $message . "</p>";
                                            }
                                        }
                                    } else {
                                        echo "<h5 class='text-center'>No chat history available</h5>";
                                    }
                                } else {
                                    echo "<h5 class='text-center'>No recipient selected</h5>";
                                }
                            }
                            catch(Exception $ex) {
                                $errorMessages = array(
                                    "message" => $ex->getMessage()
                                );
                            }
                        ?> 
                    </div>
                </div>
                <div class="col-md-3 col-xs-12 col-sm-12">
                    <form id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="pt-4 sticky-top">
                        <div class="form-group">
                            <label>Recipient</label>
                            <select id="recipient" name="recipient" class="form-control" required>
                                <?php
                                    try {
                                        require "AssignRepository.php";
                                        $assignRepo = new AssignRepository();
                                        
                                        switch(getUserEntity()){
                                            case 'tutor':
                                                $recipient = $assignRepo->getStudent(getUserEmail());
                                                break;

                                            case 'student':
                                                $recipient = $assignRepo->getTutor(getUserEmail());
                                                print_r($recipient);
                                                break;

                                            default:
                                                $recipient = array();
                                        }                        

                                        if(count($recipient) > 0){
                                            foreach($recipient as $value){
                                                echo "<option value='" . $value['email'] . "'>" . $value['name'] . "</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>No recipient available</option>";
                                        }
                                    }
                                    catch(Exception $ex){
                                        echo "<option value='' disabled>No recipient available</option>";
                                        $errorMessages = array(
                                            "message" => $ex->getMessage()
                                        );
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" class="btn btn-success btn-block" value="Connect" formnovalidate />
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" class="form-control" style="height:120px;resize:none" required maxlength="500"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block" name="submit" value="Send" />
                        </div>
                        <?php 
                            echo "<div class='form-group'>";
                            if(!empty($successMessage)) {
                                Utility::loadSuccess($successMessage);
                            }

                            if(!empty($errorMessages)){
                                Utility::loadError($errorMessages);
                            }
                            echo "</div>";
                        ?>
                    </form>
                </div>
            </div>
        </main>
        <?php Utility::loadJs(array("jquery-3.4.1.min.js", "bootstrap.min.js")); ?>
        <audio id="msgTone" src="assets/media/msgtone.mp3" preload="auto"></audio>
        <script type="text/javascript">
            $(document).ready(
                function(){
                    window.scrollTo(0,document.body.scrollHeight);

                    $('#recipient').val("<?php if(!empty($_POST['recipient'])){ echo $_POST['recipient']; } ?>");

                    $("#message").focus();

                    var conn = new WebSocket("ws://localhost:8080");

                    conn.onopen = function(e) {                        
                        conn.send(JSON.stringify({ flag : "token", username : "<?php echo $_SESSION['Email']; ?>" }));
                        console.log("Connection opened.");
                    }

                    conn.onmessage = function(e) {
                        var result = JSON.parse(e.data);
                        document.getElementById("msgTone").play();
                        if(result['sender'] !== $('#recipient').val()) {
                            alert("You have a new message from " + result['sender']);
                        } else {
                            $('#chatbox').append("<p class='ml-4 text-justify p-3 bg-secondary' style='margin-right : 120px'>" + result['message'] + "</p>");
                            window.scrollTo(0,document.body.scrollHeight);
                        }
                    }                                                        

                    conn.onerror = function(e){
                        var div = document.createElement("div");
                        div.className = "alert alert-warning text-justify";
                        var p = document.createElement("p");
                        p.innerHTML = "Real time feature is not available. Please connect to the recipient from time to time to get the latest update.";
                        div.appendChild(p);
                        $('#form').append(div);
                        console.log(div);
                    }

                    $(".deleteLink").click(
                        function(event) {                            
                            event.preventDefault();
                            if(confirm("Confirm deleting message? It is irreversible.")){
                                return true;
                            } else {
                                return false;
                            }
                        }
                    );

                    $(":submit").on('click', function() {
                        switch($(this).val()){
                            case 'Send':
                                if($('#message').val().trim().length > 0) {
                                    conn.send(JSON.stringify({ flag: "message", message : $('#message').val(), recipient : $('#recipient').val() }));
                                } else {
                                    alert("Invalid message");
                                }
                                return true;                                

                            case 'Connect':
                                return true;
                                break;
                        }                        
                    })
                }
            );
        </script>                                    
        <?php Utility::loadFooter(); ?>
    </body>
</html>
