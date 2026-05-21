<?php
/*
Plugin Name: Chatbot Diskominfo yaw
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
<div id="chatbot-button" onclick="toggleChat()" title="Chatbot"> 
<svg width="43" height="50" viewBox="0 0 128 128" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path
    d="M64 16C37.49 16 16 34.8 16 58C16 71.5 23.4 83.5 35.2 91.2L30 112L51.6 100.4C55.6 101.4 59.7 102 64 102C90.51 102 112 83.2 112 60C112 36.8 90.51 16 64 16Z"
    fill="#024e9e"
  />

  <circle cx="105" cy="25" r="20" fill="#ff4444"/>
  <text x="105" y="33" font-size="26" font-weight="bold" fill="white" text-anchor="middle">1</text>
  <!-- Three gray dots -->
  <circle cx="46" cy="60" r="6" fill="#BDBDBD"/>
  <circle cx="64" cy="60" r="6" fill="#BDBDBD"/>
  <circle cx="82" cy="60" r="6" fill="#BDBDBD"/>
</svg>
</div>


<!-- Popup Chat -->
    <div id="chatbot-container">

        <div id="chatbot-header">
            <div style="display:flex; justify-content:space-between; align-items:center;">

                <!-- Profil Bot -->
                <div style="display:flex; align-items:center; gap:10px;">

                    <div style="position:relative; width:40px; height:40px;">

                        <!-- SVG Avatar Chatbot -->
                        <svg width="40" height="40" viewBox="0 0 64 64" fill="none"
                            xmlns="http://www.w3.org/2000/svg">

                            <!-- Background -->
                            <circle cx="32" cy="32" r="32" fill="#ffffff22" />

                            <!-- Kepala Robot -->
                            <rect x="16" y="18" width="32" height="24" rx="8" fill="white" />

                            <!-- Antena -->
                            <line x1="32" y1="12" x2="32" y2="18"
                                stroke="white"
                                stroke-width="3"
                                stroke-linecap="round" />

                            <circle cx="32" cy="10" r="3" fill="white" />

                            <!-- Mata -->
                            <circle cx="25" cy="30" r="3" fill="#024e9e" />
                            <circle cx="39" cy="30" r="3" fill="#024e9e" />

                            <!-- Mulut -->
                            <rect x="24" y="36" width="16" height="3" rx="2" fill="#024e9e" />

                        </svg>

                        <!-- Status Online -->
                        <span style="
                    position:absolute;
                    bottom:2px;
                    right:2px;
                    width:10px;
                    height:10px;
                    background:#00ff4c;
                    border:2px solid white;
                    border-radius:50%;
                "></span>
                    </div>

                    <!-- Nama -->
                    <div style="display:flex; flex-direction:column; line-height:1.1;">
                        <span style="display:flex; align-items:center; gap:5px; font-weight:bold;">
                            Cami

                            <!-- Verified Badge -->
                            <span title="Terverified" style="display:flex; align-items:center; cursor:pointer;">

                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">

                                    <!-- Verified Shape -->
                                    <path
                                        d="M12 1L15 3L19 2L20 6L23 9L20 12L21 16L17 17L15 21L12 19L9 21L7 17L3 16L4 12L1 9L4 6L5 2L9 3L12 1Z"
                                        fill="#1D9BF0" />

                                    <!-- Check -->
                                    <path
                                        d="M8 12L11 15L16 9"
                                        stroke="white"
                                        stroke-width="2.5"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </span>
                        </span>
                        <small style="color:#b7ffb7;">Online</small>
                    </div>
                </div>

                <!-- Tombol Close -->
                <button id="close-chat-btn"
                    onclick="toggleChat()"
                    style="background:none; border:none; color:white; font-size:20px; cursor:pointer; padding:0; width:25px; height:25px; display:flex; align-items:center; justify-content:center;">
                    &times;
                </button>

            </div>
        </div>
        <div id="chat-output"></div>

        <div id="chatbot-input-area">

            <input type="text"
                id="chat-input"
                placeholder="Tulis pesan..."
                onkeypress="if(event.key==='Enter')sendMessage()">

            <button onclick="sendMessage()" style="background:none; border:none; padding:8px; cursor:pointer; display:flex; align-items:center; justify-content:center;">
                <svg viewBox="0 0 24 24" fill="#0073aa" xmlns="http://www.w3.org/2000/svg" style="width:24px; height:24px;">
                    <path d="M16.6915026,12.4744748 L3.50612381,13.2599618 C3.19218622,13.2599618 3.03521743,13.4170592 3.03521743,13.5741566 L1.15159189,20.0151496 C0.8376543,20.8006365 0.99,21.89 1.77946707,22.52 C2.41,22.99 3.50612381,23.1 4.13399899,22.8429026 L21.714504,14.0454487 C22.6563168,13.5741566 23.1272231,12.6315722 22.9702544,11.6889879 L4.13399899,1.16346275 C3.34915502,0.9 2.40734225,1.00636533 1.77946707,1.4776575 C0.994623095,2.10604706 0.837654326,3.0486314 1.15159189,3.99021575 L3.03521743,10.4310088 C3.03521743,10.5881061 3.34915502,10.7452035 3.50612381,10.7452035 L16.6915026,11.5306905 C16.6915026,11.5306905 17.1624089,11.5306905 17.1624089,12.0019827 C17.1624089,12.4744748 16.6915026,12.4744748 16.6915026,12.4744748 Z"/>
                </svg>
            </button>

        </div>

    </div>

<?php
    echo ob_get_clean(); 
}

add_action('wp_footer', 'chatbot_ui');

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
let chatboxFirstTime = true;

function toggleChat() { 

    let chatbox =
        document.getElementById("chatbot-container"); 

    if(chatbox.style.display === "flex") { 

        chatbox.style.display = "none"; 

    } else {

        chatbox.style.display = "flex";
        
        // Tampilkan greeting message saat pertama kali dibuka
        if(chatboxFirstTime) {
            const chatOutput = document.getElementById("chat-output");
            chatOutput.innerHTML = `
                <div style="display: flex; flex-direction: column; align-items: center; padding: 30px 20px; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 10px; justify-content: center;">
                        <h3 style="font-size: 24px; font-weight: 600; margin: 0; color: #333; text-align: center;">Halo</h3>
                        <svg width="32" height="32" viewBox="0 0 365.419 365.419" fill="none" xmlns="http://www.w3.org/2000/svg" style="display: inline-block;">
                            <defs>
                                <style>.a{fill:#fce0cd;}.b{fill:#211916;}.c{fill:#f5e06c;}</style>
                            </defs>
                            <path class="a" d="M74.947,349.208c1.495-6.049,2.887-12.2,2.787-18.429s-.887-12.807-4.988-17.5a73.742,73.742,0,0,1-11.879-13.1c-11.617-16.688-14.306-37.983-17.782-57.759-2.884-9.56-8.346-42.75-17.59-64.039-6.08-12.552-10.219-25.122-11.509-38.8-.5-5.307.8-11.581,5.312-14.411,2.584-1.619,9.449-2.465,12.33-1.468a36.628,36.628,0,0,1,9.39,5.771c11.81,9.95,16.555,20.717,20.388,35.53,1.479,4.827,8.5,19.762,15.173,31.416,5.78-2.452,11.53-8.939,14.7-13.9,1.461-5.92,10.2-27.839,11.064-34.134,4.218-20.184,5.655-29.424,8.17-48.619,1.914-14.611,5.019-35.8,7.184-47.437.646-11.41,4.718-31.226,6.8-35.26s5.735-7.38,10.275-7.51c7.655-.219,11.676,3.873,15.123,9.848,3.743,6.491,3.279,22.26.581,37.629-.67,16.283-3.626,34.382-4.927,44.969-1.531,15.852-2.826,32.143-3.717,50.008-.026,5.239,14.725,6.289,16.936,3.122,3.114-9.937,12.532-40.86,16.193-52.883,2.289-11.375,13.324-50.3,15.945-59.206,3.4-11.539,5.455-22.815,11.916-33.416,4.871-7.994,15.515-7.988,18.933-6.4s6.7,6.822,7.517,10.755c2.267,10.8-4.995,33.429-6.269,38.436-.118.466-8.812,39.339-13.324,55.164-4.342,19.622-8.408,39.171-12.673,59.2.711,4,9.866,8.534,15.045,5.782,6.578-6.064,19.222-29.289,23.319-37.936,5.83-13.417,15.46-32.151,19.742-42.057l16.812-33.091c2.573-5.064,5.91-10.744,12.047-10.8A10.382,10.382,0,0,1,291.71,52.3c4.043,4.533,4.5,10.65,4.131,16.417-.654,10.287-5.143,24.354-9.853,33.523-3.292,8.443-15.911,37.689-20.566,46.036-2.376,7.755-14.9,34.389-17.026,39.158-2.159,4.98.787,10.294,3.253,11.6,2.608,1.381,5.407,2.712,7.413.526a377.735,377.735,0,0,1,30.749-22.386c5.337-4.822,12.348-10.766,18.133-15.022,7-6.967,16.533-14.044,24.761-14.364a13.28,13.28,0,0,1,5,.595,7.968,7.968,0,0,1,4.054,5.269c1.092,3.975.024,8.3-2,11.884s-4.948,6.577-7.834,9.521c-3.328,3.394-7.876,8.843-11.2,12.237l-23.8,23.679A239.252,239.252,0,0,1,269.943,236.8c-2.281,1.865-4.595,3.688-6.91,5.511-3.926,3.093-8.251,12.3-14.422,23.536-5.688,15.64-28.45,56.844-35.812,65.508-5.131,6.037-14.986,13.716-20.931,18.954a41.779,41.779,0,0,0-1.063,12.8"></path>
                        </svg>
                    </div>
                    <p style="font-size: 14px; color: #666; margin: 0; text-align: center;">Ada yang bisa Cami bantu?</p>
                </div>
            `;
            chatOutput.scrollTop = chatOutput.scrollHeight;
            chatboxFirstTime = false;
        }
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
    bottom:35px; 
    right:157px; 

    width:50px; 
    height:50px; 

    background:#e2e3e8; 
    color:white; 

    border-radius:50%; 

    display:flex; 
    justify-content:center; 
    align-items:center; 

    font-size:28px; 

    cursor:pointer; 

    z-index:9999; 
}
#chatbot-button:hover { transform: scale(1.08); } 

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

    background:transparent;

    color:#0073aa;

    border:none;

    padding:8px;

    cursor:pointer;
    
    display:flex;
    
    align-items:center;
    
    justify-content:center;
    
    flex-shrink:0;
}

#chatbot-input-area button svg{
    
    width:24px;
    
    height:24px;
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