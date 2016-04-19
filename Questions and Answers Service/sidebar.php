<div class="logo">
    <img src="<?php header_image(); ?>"
         width="<?php echo get_custom_header()->width; ?>" alt=""/>
</div>
<p class="descr"><?php echo bloginfo('name') ?></p>
<div id="chat">
    
    <div id="lhc_status_container_page" ></div>

    
    <script type="text/javascript">
        var LHCChatOptionsPage = {};
        LHCChatOptionsPage.opt = {};
        (function() {
            var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
            po.src = ''; //Path to LHC
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
        })();
    </script>
</div>