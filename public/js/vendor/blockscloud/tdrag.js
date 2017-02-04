define("vendor/blockscloud/tdrag", ["tdrag"], function(require) {
  jQuery(function(){
    // 动态元素绑定拖拽临时解决办法
    $('.app-list').on("mouseover",'.app-box',function(event){
      $(this).Tdrag({
          scope:".app-list",
          // pos:true,
          dragChange:true,
          changeMode:"sort"
      });
    });

    $('.app-box').Tdrag({
        scope:".app-list",
        // pos:true,
        dragChange:true,
        changeMode:"sort"
    });

  });
})