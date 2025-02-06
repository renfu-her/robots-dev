var fancyboxOption = {
    margin: 10,
    padding: 0,
    maxWidth: '100%',
    nextEffect: 'fade',
    prevEffect: 'fade',
    autoSize: false,
    closeBtn: false,
    wrapCSS: 'fancybox-album',
    afterLoad: function() {
        this.skin.append( '<div class="photo-title"><i class="ic-album"></i>'+this.title+'</div><div class="photo-intro">'+$(this.element).data("intro")+'</div><div class="photo-pager"><b>'+padLeft(this.index+1, 2)+'</b> / '+padLeft(this.group.length, 2)+'</div>' );
        this.title = '<a title="Close" class="fancybox-item fancybox-close" href="javascript:parent.jQuery.fancybox.close();"></a>';
    },
    helpers : {
        title : {
            type : 'outside',
            position: 'top'
        },
        overlay : {
            css : {
                'background' : 'rgba(0,0,0,0.8)'
            }
        },
        thumbs  : {
            width   : 80,
            height  : 80
        }
    }
};

$(document).ready(function(){
   $(".album-list .open-album").click(function() {
        if($(this).parents('.box').siblings('.fancybox').length>0) {
            $.fancybox($(this).parents('.box').siblings('.fancybox'), fancyboxOption);
        }
        return false;
    });
});

