(function ($, doc, win) {
    $(doc).ready(function () {
        console.log('加载模板');
        /*
         * 根据Value格式化为带有换行、空格格式的HTML代码
         * @param strValue {String} 需要转换的值
         * @return  {String}转换后的HTML代码
         * @example
         * getFormatCode("测\r\n\s试")  =>  “测<br/> 试”
         */
        var getFormatCode = function(strValue){
            return strValue.replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, ' ');
        };

        var toolbar = $('#ed_toolbar');
        var content = $('#content');
        //插入渲染模板
        toolbar.before('<div id="stackedit-template">Hello world!</div>');
        //将文本编辑器的内容渲染到渲染模板
        $('#stackedit-template').html(getFormatCode(content.val()));

        //toolbar.css('display','none');
        //content.css('display','none');

        // $('#publish').click(function () {
        //     alert('a');
        // });
    });
})(jQuery, document, window);