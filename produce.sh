#!/bin/bash
# 删除文件(夹)
rm -rf .idea/
rm -rf .DS_Store
rm -rf .git/
rm -rf .gitignore
rm -rf README.md

#assets
rm -rf assets/jade/jade.css
rm -rf assets/jade/jade.js
rm -rf assets/stackedit/stackedit.js
rm -rf assets/turndown/turndown.js
rm -rf assets/typo/typo.css

#Document
rm -rf docs/

#screenshot
rm -rf screenshot/

#includes
rm -rf includes/options/assets/css/main.css
rm -rf includes/options/assets/js/main.js

#languages
rm -rf includes/languages/*.po

#produce.sh
rm -rf produce.sh