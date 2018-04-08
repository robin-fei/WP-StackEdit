(function ($, doc, win) {
    $(doc).ready(function () {
        //声明to markdown
        var options = {
            codeBlockStyle: 'fenced',
            fence: '```'
        };
        var turndownService = new window.TurndownService(options);
        var toolbar = $('#ed_toolbar');
        var content = $('#content');
        var htmlSrc = content.val();
        var blocksRge = /(<code>[\s\S].*?<\/code>)|(<pre>[\s\S]*?<\/pre>)/gi; //适配代码块 <pre><code></code></pre> | <pre></pre> | <code></code>
        var newlineRge = /(&#10;){2,}/g; //适配换行符 &#10;

        //插入渲染模板
        toolbar.before('<div id="stackedit-template"></div>');

        //配置转换函数(针对代码块)
        turndownService.addRule('strikethrough', {
            filter: function (node) {
                return (
                    node.nodeName === 'PRE' &&
                    node.firstChild &&
                    node.firstChild.nodeName === 'CODE'
                );
            },
            replacement: function(content, node) {
                var className = node.firstChild.className || '';
                var language = (className.match(/language-(\S+)/) || [null, ''])[1];
                return '```'+ language +'\n' + content + '\n```\n';
            }
        });

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
            stackedit.on('fileChange', function onFileChange(file) {
                document.getElementById('title').value = file.name; //更新标题
                //正则抓取内容适配代码块
                // var i = (file.content.html).match(blocksRge);
                // for (var p in i) {
                //     var x = i[p].match(newlineRge);
                //     x[x.length - 1].replace(newlineRge,'&#10;');
                //
                //     console.log(x[x.length - 1]);
                // }

                content.html(file.content.html); //更新文本框内容
                $('#stackedit-template').html(file.content.html); //更新渲染框内容
            });

            //关闭编辑器执行的操作
            stackedit.on('close', function onClose(file) {
                htmlTpl();
                doc.getElementById('stackedit-status').innerText = 'Disabled';
            });

        }

        //执行操作
        htmlTpl();
        jade.openEdit === '1' ? openStackedit(false) : '';

        //点击StackEdit按钮事件
        doc.getElementById('stackedit-status').addEventListener('click',function onClick() {
            openStackedit(false);
            this.innerText = 'Enable';
        });
    });
})(jQuery, document, window);