<!-- 記得自己需要引入 jquery的CDN
以及建立基礎table元素，還有置入所需的變數

<table id="datatable" class="display">
    
</table>

特定input變數命名
如果有使用圖片，則input name為imgUrl
email則name=email
date則name=date


API要以restful結構才可以，例如:
查詢全部資料 get    : localhost/news 
新增一筆資料 post   : localhost/news 
更新一筆資料 patch  : localhost/news/id 
刪除一筆資料 delete : localhost/news/id

變數
    //datatable_start : 輸入任何大於0的值表示使用，慣例輸入"Y"，若不使用就不必宣告。
    //datatable_getAlldata : 查詢全部資料
    //datatable_createData : 新增資料的API
    //datatable_deleteData : 刪除資料的API
    //datatable_updateData : 更新資料的API
    //datatable_title : 表格標題與順序
    //datatable_sortBy : 要以第幾欄作為排序
    //datatable_hasImg : 輸入Y表示有圖片，不輸入就採無圖片樣式。
    
    //datatable_pk : 主key(只能有一個)
    
function
    //datatable_customerFunc : 客製化function寫在裡面

    
 ======================使用範例==================   
// datatable 前置設定 (開始)
    let restfulApi = "http://127.0.0.1:8000/api/user";

    let datatable_start = "Y";
    let datatable_getAlldata = restfulApi;
    let datatable_createData = restfulApi;
    let datatable_deleteData = restfulApi + "/";
    let datatable_updateData = restfulApi + "/";
    let datatable_title = ['id', 'name', 'email', "password", "admin"];
    let datatable_pk = ['id'];
    let datatable_sortBy = "2";

    function datatable_customerFunc() {
        $('#updateData').click(function(){
            $("#password").parent().hide();
        })
    }
// datatable 前置設定 (結束)

-->


<!-- jqueyUI CDN -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<!-- datatable api CDN-->
<link href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<!-- axios CDN -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


<script>
    axios.defaults.headers.common = {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }



    function resetDialog() {
        $("#ui-id-1").text("");
        for (i = 0; i < datatable_title.length; i++) {
            $(`#${datatable_title[i]}`).val("");
        }

        $('#dialogForm input:hidden').parent().show();
        $('#dialogForm input:disabled').prop('disabled', false);

        if (!(typeof(datatable_hasImg) == 'undefined')) { //使用圖片
            $("#updateToggleArea").remove();
            $("#updateToggleBtn").unbind("click");
            $("#imgUrl").prop('type','file');
        }


    }

    function createDataTable(column) {
        $('#datatable').DataTable({
            "order": [
                [column, "desc"]
            ]
        });
    }

    function createDialog() {
        let dialog_form = "<form id='dialogForm'>";
        for (i = 0; i < datatable_title.length; i++) {
            dialog_form += `<div class="form-group"><label class="col-3 mr-5" for="${datatable_title[i]}">${datatable_title[i]}</label><input class="col-9" type="text" name="${datatable_title[i]}" id="${datatable_title[i]}"></div>`;
        }
        dialog_form += '</form>';
        let dialogHTML = '<div id="dialog" title="Basic dialog" style="">' + dialog_form + '</div>';
        $("#datatable").after(dialogHTML);
        $('#dialogForm').submit(
            function() {
                return false;
            }
        );
        $("input[name='date']").prop('type', 'datetime-local');
        $("input[name='email']").prop('type', 'email');
        $("input[name='content']").replaceWith($('<textarea id="content" name="content" rows="4" cols="50">' + '</textarea>'));
        if (!(typeof(datatable_hasImg) == 'undefined')) {
            $("input[name='imgUrl']").prop('type', 'file');
        }

        $("#dialog").dialog({
            autoOpen: false,
            show: {
                effect: "blind",
                duration: 500
            },
            hide: {
                effect: "explode",
                duration: 500
            },
            open: function() {
                // alert('open');
            },
            close: function() {
                resetDialog();
                // alert('close');
            },
            buttons: {
                "送出": function() {

                    let obj = {};
                    for (i = 0; i < datatable_title.length; i++) {
                        obj[datatable_title[i]] = $(`#${datatable_title[i]}`).val();
                    }

                    for (i = 0; i < datatable_pk.length; i++) {
                        delete obj[datatable_pk[i]];
                    }

                    if ($("#ui-id-1").text() == "新增") {
                        if (!(typeof(datatable_hasImg) == 'undefined')) { //使用圖片
                            obj['imgUrl'] = $('#imgUrl').prop('files')[0];
                            let data = new FormData();
                            for (i = 0; i < datatable_title.length; i++) {
                                data.append(`${datatable_title[i]}`, $(`#${datatable_title[i]}`).val());
                            }
                            data.delete('imgUrl');
                            data.append('imgUrl', $('#imgUrl').prop('files')[0])

                            axios.post(datatable_createData, data).then(function(e) {
                                window.location.reload();
                            });;
                        } else { //無使用圖片
                            axios.post(`${datatable_createData}`, obj).then(function(e) {
                                window.location.reload();
                            });
                        }

                    } else if (($("#ui-id-1").text() == "更新")) {
                        if (!(typeof(datatable_hasImg) == 'undefined')) { //使用圖片
                            if ($("#imgUrl").prop('type') == 'text') { //使用舊圖片
                                
                                let data = new FormData();
                                for (i = 0; i < datatable_title.length; i++) {
                                    data.append(`${datatable_title[i]}`, $(`#${datatable_title[i]}`).val());
                                }
                                data.append('_method', 'PATCH');
                                let pk = $(`#${datatable_pk}`).val();
                                axios.post(`${datatable_updateData+pk}`, data).then(function(e) {
                                    window.location.reload();
                                });;
                            } else { //使用新圖片
                                
                                let data = new FormData();
                                for (i = 0; i < datatable_title.length; i++) {
                                    data.append(`${datatable_title[i]}`, $(`#${datatable_title[i]}`).val());
                                }
                                data.delete('imgUrl');
                                data.append('imgUrl', $('#imgUrl').prop('files')[0])
                                data.append('_method', 'PATCH');

                                let pk = $(`#${datatable_pk}`).val();
                                axios.post(`${datatable_updateData+pk}`, data).then(function(e) {
                                    window.location.reload();
                                });;
                            }
                        } else { //沒使用圖片
                            let pk = $(`#${datatable_pk}`).val();

                            axios.patch(`${datatable_updateData+pk}`, obj).then(function(e) {
                                // console.log(e);
                                window.location.reload();
                            });
                        }


                    }


                    $(this).dialog("close");
                },
                "取消": function() {
                    $(this).dialog("close");
                }
            }
        });
        $(".ui-dialog-titlebar-close").html("X");
        $(".ui-dialog-titlebar-close").css({
            "font-size": "10px"
        });


        //註冊新增按鈕事件
        $("#createData").on("click", function() {
            $("#ui-id-1").text("新增");

            for (i = 0; i < datatable_pk.length; i++) {
                $(`#${datatable_pk}`).parent().hide();
            }

            $("#dialog").dialog("open");

        });

        //註冊更新按鈕事件
        $("#updateData").on("click", function() {
            $("#ui-id-1").text("更新");

            $(`#${datatable_pk}`).prop('disabled', true);

            let checked = $("input[type='checkbox']:checked").length;
            if (checked > 1) {
                alert('一次只能選取一個項目 !');
            } else if (checked < 1) {
                alert('請選取至少一個項目 !');
            } else {
                for (i = 0; i < datatable_title.length; i++) {

                    if (datatable_title[i] == 'imgUrl') {
                        continue;
                    }

                    let text = $("#datatable input[type='checkbox']:checked").parent().parent().children().eq(i + 1).text();

                    if (datatable_title[i] == 'date') {
                        text = text.replace(" ", "T");
                        $(`#${datatable_title[i]}`).val(text);
                    } else {
                        $(`#${datatable_title[i]}`).val(text);
                    };


                };
                if (!(typeof(datatable_hasImg) == 'undefined')) { //使用圖片
                    $("#imgUrl").parent().children().eq(0).after($("<p id='updateToggleArea'><input id='updateToggleBtn' type=checkbox /><label for='updateToggleBtn'>使用既有圖片</label></p>"))
                    $("#updateToggleBtn").click(function() {
                        if ($("#imgUrl").prop('type') == 'file') {
                            $("#imgUrl").prop('type', 'text');
                        } else if ($("#imgUrl").prop('type') == 'text') {
                            $("#imgUrl").prop('type', 'file');
                        }

                    });

                }

                $("#dialog").dialog("open");
            }



        });

        //註冊刪除按鈕事件
        $("#deleteData").on("click", function() {

            let checked = $("input[type='checkbox']:checked").length;
            let pkIndex = $(`#${datatable_pk}`).index();
            let deleteIdArr = [];
            for (i = 0; i < checked; i++) {
                let deleteId = $("#datatable input[type='checkbox']:checked").parent().parent().eq(i).children().eq(pkIndex).text();
                deleteIdArr.push(deleteId);
            }
            for (i = 0; i < deleteIdArr.length; i++) {
                axios.delete(datatable_deleteData + deleteIdArr[i]);
            }
            window.location.reload();
            // console.log("刪除ID : "+deleteIdArr);




        });
    }


    $(function() {

        if (!(typeof(datatable_start) == 'undefined')) { //有啟用datatable功能才執行。
            $.ajax(datatable_getAlldata).then(function(e) {


                if (!(typeof(datatable_hasImg) == 'undefined')) { //有使用圖片

                    axios.defaults.headers.post['Content-Type'] = 'multipart/form-data';
                    axios.defaults.headers.patch['Content-Type'] = 'multipart/form-data';

                    let thead = "<thead><th>chose</th>";
                    for (i = 0; i < datatable_title.length; i++) {
                        thead += `<th>${datatable_title[i]}</th>`;
                    }
                    thead += "<th>縮圖</th></thead>";

                    let tbody = "<tbody>";

                    for (i = 0; i < e.length; i++) {

                        tbody += "<tr>+<td><input type='checkbox' style='width:40px;height:40px'></td>";
                        for (j = 0; j < datatable_title.length; j++) {
                            tbody += `<td>${e[i][datatable_title[j]]}</td>`;
                        }
                        tbody += `<td><img src='/images/${e[i]['imgUrl']}' style='height: 60px;width: 60px;'></td></tr>`;
                    }
                    tbody += "</tbody>";

                    let datatable_html = thead + tbody;
                    $('#datatable').html(datatable_html);
                } else { //沒使用圖片
                    let thead = "<thead><th>chose</th>";
                    for (i = 0; i < datatable_title.length; i++) {
                        thead += `<th>${datatable_title[i]}</th>`;
                    }
                    thead += "</thead>";

                    let tbody = "<tbody>";

                    for (i = 0; i < e.length; i++) {

                        tbody += "<tr>+<td><input type='checkbox' style='width:40px;height:40px'></td>";
                        for (j = 0; j < datatable_title.length; j++) {
                            tbody += `<td>${e[i][datatable_title[j]]}</td>`;
                        }
                        tbody += "</tr>";
                    }
                    tbody += "</tbody>";

                    let datatable_html = thead + tbody;
                    $('#datatable').html(datatable_html);
                }

                //基本table已完成，只差還沒渲染datatable API

                //取消選取btn
                $('#datatable').before('<button id="cancelSelector" class="btn btn-secondary mb-2 mr-2">取消選取</button>');
                $('#cancelSelector').click(function() {
                    $("#datatable input[type='checkbox']:checked").prop('checked', false);
                });

                //新增btn
                $('#datatable').before('<button id="createData" class="btn btn-success mb-2 mr-2">新增</button>');

                //新增btn
                $('#datatable').before('<button id="updateData" class="btn btn-primary mb-2 mr-2">更新</button>');

                //新增btn
                $('#datatable').before('<button id="deleteData" class="btn btn-danger mb-2 mr-2">刪除</button>');

                createDataTable(datatable_sortBy); //渲染datatable API
                createDialog();

                if (typeof datatable_customerFunc == 'function') {
                    datatable_customerFunc();
                }



            });




        }

    })
</script>

<!-- ref

https://ithelp.ithome.com.tw/articles/10212120
https://www.bezkoder.com/axios-request/
https://laracasts.com/discuss/channels/laravel/how-can-i-use-csrf-token-with-axios-post-method

-->