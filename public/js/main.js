seajs.config({
    base: "./js/",
    preload: ["vendor/jquery/1.11.3/jquery.min","config/config","lang/zh-cn","vendor/ace/src-min-noconflict/ace","vendor/vue/2.0/vue.min"],
    alias: {
    "jquery": "vendor/jquery/1.11.3/jquery.min.js",
    "bootstrap": "vendor/bootstrap/bootstrap.min.js",
    "vue-router": "vendor/vue/2.0/vue-router.js",
    "jquery-ui": "vendor/jquery/1.11.3/jquery-ui.min.js",
    "context": "vendor/context/js/context.js",
    "sidebar-modernizr": "vendor/sidebar/js/modernizr.custom.js",
    "sidebar-classie": "vendor/sidebar/js/classie.js",
    "tdrag": "vendor/tdrag/tdrag.js",
    "appsort": "vendor/appsort/appsort.js",
    "nicescroll": "vendor/nicescroll/jquery.nicescroll.min.js",
    "layui": 'vendor/layui/layui.js',
    "layer": 'vendor/layer/layer.js',
    "cookie": 'vendor/cookie/jquery.cookie-1.4.1.min.js',
    "element-ui": 'vendor/element/index.js',
    "jplayer":'vendor/jPlayer/dist/jplayer/jquery.jplayer.min.js',
    "playlist":'vendor/jPlayer/dist/add-on/jplayer.playlist.min.js',
    }
});
seajs.use("bootstrap");
seajs.use("vue-router");
seajs.use("layer");
seajs.use("vendor/blockscloud/core");
seajs.use("vendor/blockscloud/region");
seajs.use("vendor/blockscloud/desktop");
seajs.use("vendor/blockscloud/tdrag");
seajs.use("widget/contextMenu");
seajs.use("widget/sidebar");
seajs.use("widget/dock");