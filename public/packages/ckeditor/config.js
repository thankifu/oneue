// 定义编辑器标准配置
CKEDITOR.editorConfig = function (config) {
    config.language = 'zh-cn';
    config.toolbar = [
        {name: 'document', items: ['Source']},
        {name: 'styles', items: ['Font', 'FontSize']},
        {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'TextColor', 'BGColor', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList']},
        {name: 'link', items: ['Link', 'Unlink', 'Table']},
        {name: 'image', items: ['Image', 'UploadImage', 'UploadMusic', 'UploadVideo']},
        {name: 'tools', items: ['CodeSnippet', 'Maximize']}
    ];
    config.allowedContent = true;
    config.format_tags = 'p;h1;h2;h3;pre';
    config.extraPlugins = 'codesnippet';
    config.removeButtons = 'Underline,Subscript,Superscript';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.font_names = '微软雅黑/Microsoft YaHei;宋体/SimSun;新宋体/NSimSun;仿宋/FangSong;楷体/KaiTi;黑体/SimHei;' + config.font_names;
    config.codeSnippet_theme = 'dracula';
};
