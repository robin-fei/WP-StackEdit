(function ($, doc, win) {
    $(doc).ready(function () {
        //声明to markdown
        var options = {
            codeBlockStyle: "fenced",
            fence: "```"
        };
        var turndownService = new window.TurndownService(options);
        var toolbar = $('#ed_toolbar');
        var content = $('#content');
        var htmlSrc = content.val();//.replace(/(\n){1,}/g,'').replace(/(\r\n){1,}/g,'');
        console.log(htmlSrc);

        //插入渲染模板
        toolbar.before('<div id="stackedit-template"></div>');

        /**
         * 将文本编辑器的内容渲染到渲染模板
         * @returns boolean
         */
        function htmlTpl() {
            //$('#stackedit-template').html(content.val().replace(/\r\n/g, '<br/>').replace(/\n/g, '<br/>').replace(/\s/g, ' '));
            $('#stackedit-template').html(htmlSrc);
        }

        /**
         * 打开编辑器函数
         * @param isOpen false默认打开 true默认关闭
         */
        function openStackedit(isOpen) {
            //声明编辑器并且初始化配置
            var stackedit = new Stackedit({
                url: jade.stackEditUrl
            });

            //打开编辑器执行的配置
            stackedit.openFile({
                    name: $('#title').val(),
                    content: {
                        text: turndownService.turndown(htmlSrc)
                    }
                },
                isOpen
            );

            //打开编辑器执行的操作
            stackedit.on("fileChange", function onFileChange(file) {
                document.getElementById('title').value = file.name;
                content[0].innerHTML = file.content.html;
                $('#stackedit-template').html(file.content.html);
            });

            //关闭编辑器执行的操作
            stackedit.on("close", function onClose(file) {
                htmlTpl();
                doc.getElementById('stackedit-status').innerText = '禁用状态';
            });

        }

        //执行操作
        htmlTpl();
        jade.openEdit === '1' ? openStackedit(false) : openStackedit(true);

        //点击StackEdit按钮事件
        doc.getElementById('stackedit-status').addEventListener('click',function onClick() {
            openStackedit(false);
            this.innerText = '开启状态';
        });
    });
})(jQuery, document, window);