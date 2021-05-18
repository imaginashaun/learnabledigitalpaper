<template>

    <div>

        <div id="cometchat_embed_synergy_container"></div>

    </div>
</template>

<script>

    window.chat_id = Math.random()
    window.chat_name = 'USER'
    window.chat_avatar = 'USER_AVATAR'
    window.chat_link = 'USER_PROFILELINK'
    var js = document.createElement('script')
    js.type = 'text/javascript'
    js.src = 'https://fast.cometondemand.net/' + window.chat_appid + 'x_xchatx_xcorex_xembedcode.js'
    var s = document.getElementsByTagName('script')[0]
    s.parentNode.insertBefore(js, s)

    js.onload = function () {
        window.chat_iframe.style = 'width:' + window.chat_width + ';height:' + window.chat_height + ';max-width:100%;border:0px solid #CCCCCC;border-radius:5px;overflow:hidden;'
        window.chat_iframe.module = 'synergy'
        window.chat_iframe.width = window.chat_width.replace('px', '')
        window.chat_iframe.height = window.chat_height.replace('px', '')
        window.chat_iframe.src = 'https://' + window.chat_appid + '.cometondemand.net/cometchat_embedded.php'
        if (typeof (window.addEmbedIframe) === 'function') {
            window.addEmbedIframe(window.chat_iframe)
        }
    }
    </script>
