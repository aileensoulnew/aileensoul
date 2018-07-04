<link rel="stylesheet" href="<?php echo base_url('assets/n-css/component.css') ?>" />
<button class="bg-menu" id="showRight">
    <svg viewBox="0 0 53 53" width="25px" height="25px">
            <path d="M2,13.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,13.5,2,13.5z" />
            <path d="M2,28.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,28.5,2,28.5z" />
            <path d="M2,43.5h49c1.104,0,2-0.896,2-2s-0.896-2-2-2H2c-1.104,0-2,0.896-2,2S0.896,43.5,2,43.5z" />
    </svg>
</button>
<script src="<?php echo base_url('assets/js/classie.js?ver=' . time()) ?>"></script>
<script>
var menuRight = document.getElementById( 'cbp-spmenu-s2' ),
showRight = document.getElementById( 'showRight' ),
body = document.body;
showRight.onclick = function() {
    classie.toggle( this, 'active' );
    classie.toggle( menuRight, 'cbp-spmenu-open' );
    disableOther( 'showRight' );
};

function disableOther( button ) {
    if( button !== 'showRight' ) {
        classie.toggle( showRight, 'disabled' );
    }
}
</script>
