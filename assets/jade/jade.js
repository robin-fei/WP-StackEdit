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

        var stackEditUrl = stackedit.stackEditUrl;
        var openEdit = stackedit.openEdit;

        //插入渲染模板
        toolbar.before('<div id="stackedit-template"></div><div id="stackedit-close" class="dashicons-before dashicons-no-alt"></div>');

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
            $('#stackedit-template').html(content.val());
        }

        /**
         * 自带的编辑器从富文本切换回来没有P标签
         * 利用换行符添加个<br/>
         * @param $data
         * @returns {*}
         */
        function add_br_tag($data) {
            return $data.replace(
                new RegExp( "\\n+", "g" ),
                "<br/>"
            );
        }

        /**
         * 打开编辑器函数
         * @param isOpen false默认打开 true默认关闭
         */
        function openStackedit(isOpen) {
            //声明编辑器并且初始化配置
            var stackedit = new Stackedit({
                url: stackEditUrl
            });

            //打开编辑器执行的配置
            stackedit.openFile({
                    content: {
                        text: turndownService.turndown(add_br_tag(content.val()))
                    }
                },
                isOpen
            );

            //打开编辑器执行的操作
            stackedit.on('fileChange', function onFileChange(file) {
                console.log('实时更新的数据：',file.content.html);
                content.val(file.content.html); //更新文本框内容
                $('#stackedit-template').html(file.content.html); //更新渲染框内容
            });

            //关闭编辑器执行的操作
            stackedit.on('close', function onClose(file) {
                console.log('关闭编辑器');
                doc.getElementById('stackedit-status').innerText = 'Disabled';
            });

        }

        //点击StackEdit按钮事件
        doc.getElementById('stackedit-status').addEventListener('click',function onClick() {
            openStackedit(false);
            this.innerText = 'Enable';

            doc.getElementById('content-tmce').setAttribute('disabled','disabled');
            doc.getElementById('content-html').setAttribute('disabled','disabled');

            doc.getElementById('content').style.display = 'none';
            if( doc.getElementById('content_ifr') !== null ) {
                doc.getElementById('content_ifr').style.display = 'none';
            }

            doc.getElementById('stackedit-template').style.display = 'block';
            doc.getElementById('stackedit-close').style.display = 'block';
        });

        //关闭StackEdit渲染框按钮
        doc.getElementById('stackedit-close').addEventListener('click',function onClick() {
            doc.getElementById('stackedit-template').style.display = 'none';

            doc.getElementById('content-tmce').removeAttribute('disabled');
            doc.getElementById('content-html').removeAttribute('disabled');

            doc.getElementById('content').style.display = 'block';
            if( doc.getElementById('content_ifr') !== null ) {
                doc.getElementById('content_ifr').style.display = 'block';
            }

            doc.getElementById('stackedit-close').style.display = 'none';
        });

        //加载网页执行操作
        openEdit === '1' ? openStackedit(false) : ''; //判断默认是否自动打开编辑器
        $('#stackedit-template').html(add_br_tag(content.val()));

        //初始化禁止点击按钮
        doc.getElementById('content-tmce').setAttribute('disabled','disabled');
        doc.getElementById('content-html').setAttribute('disabled','disabled');
        //初始化隐藏编辑器
        doc.getElementById('content').style.display = 'none';
    });
})(jQuery, document, window);