<?php
/*
Plugin Name: Chatbot Diskominfo
Description: Chatbot informasi website Diskominfo
Version: 1.0
Author: Amelia
*/

if (!defined('ABSPATH')) exit;

/*
|--------------------------------------------------------------------------
| BUAT TABEL FAQ OTOMATIS
|--------------------------------------------------------------------------
*/

register_activation_hook(__FILE__, 'chatbot_create_table');

function chatbot_create_table() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'chatbot_faq';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        keyword varchar(255) NOT NULL,
        jawaban text NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);
}

/*
|--------------------------------------------------------------------------
| SHORTCODE CHATBOT
|--------------------------------------------------------------------------
*/

function chatbot_ui() { 

    ob_start();
?>

<!-- Tombol Chat -->
<div id="chatbot-button" onclick="toggleChat()"> 
    💬
</div>

<!-- Popup Chat -->
<div id="chatbot-container">

    <div id="chatbot-header">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <span>CaMi</span>
            <button id="close-chat-btn" onclick="toggleChat()" style="background:none; border:none; color:white; font-size:20px; cursor:pointer; padding:0; width:25px; height:25px; display:flex; align-items:center; justify-content:center;">&times;</button>
        </div>
    </div>

    <div id="chat-output"></div>

    <div id="chatbot-input-area">

        <input type="text"
               id="chat-input"
               placeholder="Tulis pesan..."
               onkeypress="if(event.key==='Enter')sendMessage()">

        <button onclick="sendMessage()">
            Kirim
        </button>

    </div>

</div>

<?php
    return ob_get_clean(); 
}

add_shortcode('chatbot_diskominfo', 'chatbot_ui'); 

/*
|--------------------------------------------------------------------------
| AJAX CHATBOT
|--------------------------------------------------------------------------
*/

add_action('wp_ajax_chatbot_response', 'chatbot_response'); 
add_action('wp_ajax_nopriv_chatbot_response', 'chatbot_response'); 

function chatbot_response() {

    global $wpdb;

    $message = strtolower($_POST['message']);

    $message = str_replace(
        ['?', '.', ',', '!'],
        '',
        $message
    );

    $table = $wpdb->prefix . 'chatbot_faq';

    $results = $wpdb->get_results("SELECT * FROM $table");

    $reply = "Maaf, informasi tidak ditemukan.";

    $bestMatchLength = 0;

    foreach ($results as $row) {

        $keywords = explode(',', $row->keyword);

        foreach($keywords as $keyword){

            $keyword = trim(strtolower($keyword));

            if(strpos($message, $keyword) !== false){

                // Pilih keyword paling panjang
                if(strlen($keyword) > $bestMatchLength){

                    $bestMatchLength = strlen($keyword);

                    $reply = $row->jawaban;
                }
            }
        }
    }

    echo $reply;

    wp_die();
}

/*
|--------------------------------------------------------------------------
| JAVASCRIPT
|--------------------------------------------------------------------------
*/

function chatbot_script() {  
?>

<script>
function toggleChat() { 

    let chatbox =
        document.getElementById("chatbot-container"); 

    if(chatbox.style.display === "flex") { 

        chatbox.style.display = "none"; 

    } else {

        chatbox.style.display = "flex"; 
    }
}

function sendMessage() { 

    let message = document.getElementById("chat-input").value; 

    if (!message.trim()) return;

    let formData = new FormData(); 

    formData.append("action", "chatbot_response"); 
    formData.append("message", message); 

    document.getElementById("chat-output").innerHTML += 
    "<div class='message-user'><p>" + message + "</p></div>"; 

    document.getElementById("chat-input").value = "";

    document.getElementById("chat-output").innerHTML += 
    "<div class='message-bot loading-bubble'><span></span><span></span><span></span></div>";

    document.getElementById("chat-output").scrollTop = document.getElementById("chat-output").scrollHeight;

    fetch("<?php echo admin_url('admin-ajax.php'); ?>", { 

        method: "POST", 
        body: formData 

    })

    .then(response => response.text())

    .then(data => { 

        let loadingBubble = document.querySelector(".loading-bubble");
        loadingBubble.remove();

        document.getElementById("chat-output").innerHTML += 
        "<div class='message-bot'><p>" + data + "</p></div>"; 

        document.getElementById("chat-output").scrollTop = document.getElementById("chat-output").scrollHeight;

    });
}

</script>

<?php
}

add_action('wp_footer', 'chatbot_script');

/*
|--------------------------------------------------------------------------
| CSS
|--------------------------------------------------------------------------
*/

function chatbot_style() { 
?>

<style>

#chatbot-button{ 

    position:fixed; 
    bottom:80px; 
    right:20px; 

    width:60px; 
    height:60px; 

    background:#0073aa; 
    color:white; 

    border-radius:50%; 

    display:flex; 
    justify-content:center; 
    align-items:center; 

    font-size:28px; 

    cursor:pointer; 

    z-index:9999; 
}

/* ========================= */
 
#chatbot-container{ 

    position:fixed; 
    bottom:90px; 
    right:20px;

    width:320px; 
    height:450px; 

    background:white; 

    border-radius:15px; 

    box-shadow:0 0 15px rgba(0,0,0,0.2);

    display:none; 

    flex-direction:column; 

    overflow:hidden; 

    z-index:9999; 
}

/* ========================= */

#chatbot-header{ 

    background:#0073aa; 
    color:white; 

    padding:15px; 

    font-weight:bold;
}

/* ========================= */

#chat-output{ 

    flex:1; 

    padding:10px; 

    overflow-y:auto; 

    font-size:14px; 
}

/* ========================= */

#chatbot-input-area{ 

    display:flex; 

    border-top:1px solid #ddd; 
}

/* ========================= */

#chat-input{ 

    flex:1; 

    border:none; 

    padding:10px; 

    outline:none; 
}

/* ========================= */

#chatbot-input-area button{ 

    background:#0073aa;

    color:white;

    border:none;

    padding:10px 30px;

    cursor:pointer;
}

/* ========================= */

.message-user {

    text-align: right;

    margin: 8px 0;
}

.message-user p {

    background: #0073aa;

    color: white;

    padding: 10px 15px;

    border-radius: 15px;

    display: inline-block;

    max-width: 80%;

    word-wrap: break-word;

    margin: 0;
}

/* ========================= */

.message-bot {

    text-align: left;

    margin: 8px 0;
}

.message-bot p {

    background: #e0e0e0;

    color: #333;

    padding: 10px 15px;

    border-radius: 15px;

    display: inline-block;

    max-width: 80%;

    word-wrap: break-word;

    margin: 0;
}

/* ========================= */

.loading-bubble {

    display: flex !important;

    align-items: center;

    gap: 5px;
}

.loading-bubble span {

    width: 8px;

    height: 8px;

    background: #bbb;

    border-radius: 50%;

    animation: bounce 1.4s infinite ease-in-out both;
}

.loading-bubble span:nth-child(2) {

    animation-delay: 0.2s;
}

.loading-bubble span:nth-child(3) {

    animation-delay: 0.4s;
}

@keyframes bounce {

    0%, 80%, 100% {
        opacity: 0.3;
        transform: scale(0.8);
    }

    40% {
        opacity: 1;
        transform: scale(1);
    }
}
</style>

<?php
}

add_action('wp_head', 'chatbot_style'); 