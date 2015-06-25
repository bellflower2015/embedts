/*
 * embedts.js.php
 * Kikyou Akino <bellflower@web4u.jp>
 *
 * Please put this in the same folder with tyranoscript's root folder
 * require: jQuery
 *
 * usage: <script src="//your.site/path/to/embedts.js.php?args" type="text/javascript"></script>
 *
 * args:
 *       ks: *.ks file:     e.g. 'first'
 *       w:  screen width:  e.g. 800
 *       h:  screen height: e.g. 600
 *       r:  aspect ratio:  e.g. '16:9'
 *       fs: 1 (fullscreen mode)
 *
 * defaults:
 *       ks: 'first'
 *       w:  nothing but auto detect
 *       h:  nothing but auto detect (depends on width and ratio)
 *       r:  '4:3'
 *       fs: nothing
 */

(function(){
    var getParentWidth = function(cond) {
        var w = cond.innerWidth();
        if (w > 0) return w;
        if (cond.parent().length > 0) return getParentWidth(cond.parent());
        return 0;
    };

    var scripts = document.getElementsByTagName('script');
    var script  = scripts[scripts.length - 1];
    var src     = 'first';

    var args = '';
    if (script.src.match(/\?/))
        args = script.src.replace(/^.*?\?(.*)$/, '$1');

    var arg = new Array();
    if (args.match(/[=&]/)) {
        args.split('&').map(function(pair){
            var kv = pair.split('=');
            arg[kv[0]] = kv[1];
        });
    }

    if (arg['ks'] && arg['ks'].length > 0) src = arg['ks'];
    else src = 'first';

    // aspect ratio: default 4:3
    var rX = 4, rY = 3;
    if (arg['r'] && arg['r'].match(/:/)) {
        var xy = arg['r'].split(':');
        rX = xy[0];
        rY = xy[1];
    }

    var width = 0, height = 0, fs = 0;

    if (arg['fs'] && arg['fs'] == 1) {
        fs = 1;
        $('*').css({'cssText':
            'margin:  0 !important; padding: 0 !important; border: 0 !important;'
        });
        $('body').css({'cssText':
            'margin:  0 !important; padding: 0 !important; border: 0 !important; overflow: hidden !important; background: black !important;'
        })
        width  = $(window).width();
        height = $(window).height();
        _width  = Math.floor(height / rY) * rX;
        _height = Math.floor(width / rX) * rY;
        if (_height > height) width = _width;
        else if (_width > width) height = _height;
    }
    else if (arg['w'] && arg['w'] > 0 && arg['h'] && arg['h'] > 0) {
        width  = arg['w'];
        height = arg['h'];
    }
    else if (arg['w'] && arg['w'] > 0 && ! arg['h']) {
        width  = arg['w'];
        height = Math.floor(width / rX) * rY;
    }
    else if (arg['h'] && arg['h'] > 0 && ! arg['w']) {
        height = arg['h'];
        width  = Math.floor(height / rY) * rX;
    }
    else {
        width  = getParentWidth($(script));
        height = Math.floor(width / rX) * rY;
    }

    var path = '.';
    var _path = '<?php echo dirname($_SERVER["SCRIPT_NAME"]); ?>';
    if (_path.length > 0) path = _path;

    var content = '<iframe src="'+path+'/ts.php?ks='+src+'" width="'+width+'" height="'+height+'" border="0" frameborder="0" framespacing="0" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="no"></iframe>';

    if (fs) content = '<div style="width:'+$(window).width()+'px;height:'+$(window).height()+'px;display:table-cell;text-align:center;vertical-align:middle;">'+content+'</div>';

    if (width > 0) $(script).before(content);
})();

// vim: ft=javascript :
