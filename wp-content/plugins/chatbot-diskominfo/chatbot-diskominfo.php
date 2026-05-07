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
        Chat Diskominfo
    </div>

    <div id="chat-output"></div>

    <div id="chatbot-input-area">

        <input type="text"
               id="chat-input"
               placeholder="Tulis pesan...">

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

    let formData = new FormData(); 

    formData.append("action", "chatbot_response"); 
    formData.append("message", message); 

    fetch("<?php echo admin_url('admin-ajax.php'); ?>", { 

        method: "POST", 
        body: formData 

    })

    .then(response => response.text())

    .then(data => { 

        document.getElementById("chat-output").innerHTML += 
        "<p><b>Anda:</b> " + message + "</p>"; 

        document.getElementById("chat-output").innerHTML += 
        "<p><b>Bot:</b> " + data + "</p>"; 

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
</style>

<?php
}

add_action('wp_head', 'chatbot_style'); 