/**
 * Created by xialei on 2016/9/19 0019.
 */
(function ($) {
    $.fn.extend({
        upload: function (options) {
            if (!options.url) {
                throw new Error('上传地址不能为空');
            }
            var defaults = {
                name: 'file',//上传到后端表单域的名称
                formData: null,//表单额外数据
                onProgress: function (current, total) {
                    console.log(current + '/' + total);
                },
                onSuccess: function (data) {
                    console.log('success', data);
                },
                onError: function (e) {
                    console.error(e);
                }
            };
            options = $.extend(defaults, options);
            return this.each(function () {
                $(this).on('change', function () {
                    var fd = new FormData;
                    var fieldName = this.files.length > 1 ? (options.name + '[]') : options.name;
                    var totalFiles = this.files.length;
                    var uploadedFiles = 0;
                    //添加文件
                    $.each(this.files, function () {
                        fd.append(fieldName, this);
                    });
                    //添加表单数据
                    if (options.formData !== null) {
                        $.each(options.formData, function (name, value) {
                            fd.append(name, value);
                        });
                    }
                    //事件监听
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', options.url, true);
                    xhr.onload = function () {
                        uploadedFiles++;
                        if (totalFiles > 1) {
                            options.onProgress(uploadedFiles, totalFiles);
                        }
                        options.onSuccess(xhr.responseText);
                    };
                    xhr.onerror = function (e) {
                        uploadedFiles++;
                        if (totalFiles > 1) {
                            options.onProgress(uploadedFiles, totalFiles);
                        }
                        options.onError(e);
                    };
                    xhr.upload && (xhr.upload.onprogress = function (e) {
                        if (e.lengthComputable && totalFiles == 1) {
                            options.onProgress(e.loaded, e.total);
                        }
                    });
                    //发送
                    xhr.send(fd);
                });
            });
        }
    });
})(jQuery);