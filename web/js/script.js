$(document).ready(function(){

    $(".message_details").hide();

    $(".message_head").click(function(){
        $(this).parent().next(".message_details").slideToggle("fast");
        return false;
    });

    $(".show_all_details").click(function(){
        $(".message_details").show();
        return false;
    });

    $(".hide_all_details").click(function(){
        $(".message_details").hide();
        return false;
    });


    $(".markers").click(function(){
        $(".markerRed").slideToggle("fast");
        return false;
    });




    //********************************************************
    // Функция показа вегетационного периода для сроков проведения съемки.
    //********************************************************

        function actualizeVegetPeriod() {

            var cur_subject = $('#zakupcard-fed_subject').val();
            // console.log(cur_subject);
            if(cur_subject != null) {

                // Запрашиваем из БД границы вегетационного периода по субъекту
                $.ajax({
                    url: '/lu/veget-period/get-period',
                    type: 'POST',
                    data: {"cur_subject": cur_subject},
                    success: function(data){
                        if(data){
                            $('#veget_period').val(data);
                            // console.log(data);
                        }
                    }
                });
            }
            else {
                // console.log('пусто');
            }
        }

        // Делаем недоступной опцию "выбери субъект"
        $('#zakupcard-fed_subject option').eq(0).attr('disabled','disabled'); 

        // Вызываем функцию после загрузки страницы
            actualizeVegetPeriod();

        // Вызываем функцию при выборе субъекта из списка
        $('#zakupcard-fed_subject').on('change', function() {
            actualizeVegetPeriod();
        });



    //********************************************************
    // Функция актуализации списка лесничеств (для модуля ПД)
    //********************************************************

        function actualizePdForestryList(selected_forestries = '') {

            if( $('#pdwork-federal_subject').length ) {

                var cur_subject = $('#pdwork-federal_subject').val();

                console.log('subject: ' + cur_subject );
                //console.log('selected_forestries: ' + selected_forestries)

                if(cur_subject != null) {

                    // Запрашиваем из БД лесничества для формирования списка с чекбоксами
                    $.ajax({
                        url: '/pd/pd-work/actualize-forestry-list',
                        type: 'POST',
                        data: {"cur_subject": cur_subject, "selected_forestries" : selected_forestries },
                        success: function(data){
                            if(data){
                                $('#pd_forestry_list').html(data);
                                console.log(data);
                                countSelectedForestries();
                            }
                        }
                    });
                }
                // else {  console.log('пусто'); }
            }
        }


        // Вывод дополнительных полей
        function additionalFields() {

            // Скрываем поле для ввода доп. названия проектных работ
            if($('#pdwork-work_name').val() != 25) {
                $('.field-pdwork-work_othername').css('display', 'none');
            }
            
            // Выводим поле для ввода доп. названия проектных работ
            else {
                $('.field-pdwork-work_othername').css('display', 'block');
            }


            // для лесного плана и лесохозяйственного регламента не выводим поля уч. лесничество, урочище, кварталы
            if($('#pdwork-work_name').val() == 1 || $('#pdwork-work_name').val() == 2) {
                $('.field-pdwork-subforestry').css('display', 'none');
                $('.field-pdwork-subdivforestry').css('display', 'none');
                $('.field-pdwork-quarter').css('display', 'none');

                // для лесного плана скрываем поле Лесничество
                if($('#pdwork-work_name').val() == 1) {
                    $('.field-pdwork-forestry').css('display', 'none');
                }
                // иначе отображаем поле Лесничество, если оно скрыто
                else {
                    $('.field-pdwork-forestry').css('display', 'block');
                }
            }
            // иначе отображаем поля, если они были скрыты
            else {
                $('.field-pdwork-subforestry').css('display', 'block');
                $('.field-pdwork-subdivforestry').css('display', 'block');
                $('.field-pdwork-quarter').css('display', 'block');
                $('.field-pdwork-forestry').css('display', 'block');
            }


            // Вид использования: для Лесного плана и Лесохоз. регламента 
            // ставим "иные виды" для БД, в идеале не отображаем список видов
            if ( $('#pdwork-work_name').val() == 1 || $('#pdwork-work_name').val() == 2 ) {
                $('#pdwork-forest_usage').val('17');
                $('.field-pdwork-forest_usage').fadeOut();
            }
            else {
                $('.field-pdwork-forest_usage').fadeIn();
            }

        }


        additionalFields();

        // При начальной загрузке при условии, что документация не лесной план
        // Отвечает за скрытие списка лесничеств
        function showhidePdForestryList() {
            if ($('#pdwork-work_name').val() != 1){

                $('#pd_forestry').fadeIn();
                actualizePdForestryList( $('#pdwork-forestry').val() ); 

            } else {
                $('#pd_forestry').fadeOut();
            }
        }

        showhidePdForestryList();
                

        // При изменении субъекта при условии, что документация не лесной план
        $('#pdwork-federal_subject').on('change', function() {
            if( $('#pdwork-work_name').val() != 1 ) {

                actualizePdForestryList();

                $('#pd_forestry').fadeIn();
            } else {
                $('#pd_forestry').fadeOut();
            }
        });

        // При изменении наименования работ обновляем список лесничеств, 
        // если это не лесной план и не ЛХР
        $('#pdwork-work_name').on('change', function() {
            if ( $(this).val() != 1 ) {

                actualizePdForestryList();
                additionalFields();

                $('#pd_forestry').fadeIn();
            } else {
                $('#pd_forestry').fadeOut();
            }

        });


        // По кнопке Отметить/снять все отмечаем/снимаем все чекбоксы
        $('body').on('click', '#check_all', function(){
            if ($('#check_all').is(':checked')){
                $('#pd_forestry_list input:checkbox').prop('checked', true);
            } else {
                $('#pd_forestry_list input:checkbox').prop('checked', false);
            }
        });


        // Считаем количество отмеченных лесничеств
        function countSelectedForestries() {

            var forestry_quantity = $('#pd_forestry_list input:checkbox:checked').length;
            
            $('#total_forestry span').html(forestry_quantity);
            $('#pdwork-forestry_quantity').val(forestry_quantity);
        }


        // Перечисляем через пробел ID выбранных лесничеств, выводим в строке Input
        function listSelectedForestriesId() {
            var forestry_set = '';
            
            $('#pd_forestry_list input:checkbox:checked').each(function(){
                forestry_set += $(this).val() + ' ';  // $('#list').append($(this).val() + ' ');
            });

            $('#pdwork-forestry').val(forestry_set);
        }


        $('body').on('click', '#pd_forestry input', function(){
            countSelectedForestries();
            listSelectedForestriesId();
        });



       





    //********************************************************
    // Функция актуализации списка лесничеств/ООПТ/районов (для модуля ЛУ)
    //********************************************************

        function actualizeForestryList() {

            var cur_subject = $('#zakupcard-fed_subject').val();
            var cur_land_cat = $('#zakupcard-land_cat').val();

    console.log('subject: ' + cur_subject + ' land_cat: ' + cur_land_cat);

            if(cur_subject != null) {

                // Запрашиваем из БД лесничества/ООПТ/районы для формирования выпадающего списка
                $.ajax({
                    url: '/lu/zakup-card/actualize-forestry-list',
                    type: 'POST',
                    data: {"cur_subject": cur_subject, "cur_land_cat": cur_land_cat },
                    success: function(data){
                        if(data){
                            $('#zakupcard-region').html(data);
                            console.log(data);
                        }
                    }
                });
            }
            else {
                // console.log('пусто');
            }
        }

        $('#zakupcard-fed_subject').on('change', function() {
            actualizeForestryList();
        });

        $('#zakupcard-land_cat').on('change', function() {
            actualizeForestryList();
        });

        
    //********************************************************
    // Загрузка файла с отправленным запросом КП по ДЗЗ
    //********************************************************




    $('#pdFileForm').on('beforeSubmit', function(e){

      // Создадим данные формы и добавим в них данные c файлом
      var formData = new FormData($(this).get(0));

      // Отправляем запрос
      $.ajax({
        url: '/pd/pd-work/upload',
        type: 'POST',
        data: formData,
        cache: false,
        dataType: 'json',
        processData: false, // Не обрабатываем файлы (Don't process the files)
        contentType: false, // Так jQuery скажет серверу что это строковой запрос
        success: function(data){ // удачное завершение запроса к серверу, в переменной data ответ сервера
            if(data){
                // tmpfile = data;
                // var status = '<span style="font-size: smaller; font-style: italic; color: green;">Файл ' + data + ' успешно загружен!</span>';
                // $('.help-block').html(status); 
                // console.log(data);
                var answer;
                if(data == 'nofiles') answer = 'Файлы не выбраны';
                else answer = 'файлы ' + data + ' загружены';
                console.log(answer);
                $('#PdFile').val('');
                // $('#dzzPdFile').val('');
                // обновляем списки загруженных файлов в заявках и ПД после загрузки нового
                // fileListRequest(docDir, docNameMask_pdFile, zakupNum, listDiv_pdFile);
            }
        },
        error: function(){
          var status = '<span style="color: red;">Ошибка при загрузке файла</span>';
          $('.help-block').html(status); 
          console.log('Ошибка при загрузке файла');
        }
      });
      return false;
    });




    //********************************************************
    // Добавление новой закупки
    // Названия полей лесничеств/ООПТ/районов и их состав
    // меняем в зависимости от выбранной категории земель
    //********************************************************
    function regionLabel() {

        if ( $('#zakupcard-land_cat').val() == 1 ) {
            $('.field-zakupcard-region label').text( 'Лесничество' );
            $('.field-zakupcard-region_subdiv label').text( 'Участковое лесничество' );
            $('.field-zakupcard-region_subdiv input').val('').show();
            $('.field-zakupcard-region_subdiv input').prop('disabled', false);
        }

        else if ($('#zakupcard-land_cat').val() == 2 ) {
            $('.field-zakupcard-region label').text( 'Лесничество' );
            $('.field-zakupcard-region_subdiv label').text( 'Участковое лесничество' );
            $('.field-zakupcard-region_subdiv input').val('').show();
            $('.field-zakupcard-region_subdiv input').prop('disabled', false);
        }

        else if ( $('#zakupcard-land_cat').val() == 3 ) {
            $('.field-zakupcard-region label').text( 'Район' );
            $('.field-zakupcard-region_subdiv label').text( '' );
            $('.field-zakupcard-region_subdiv input').val('Городские леса').show();
            // $('.field-zakupcard-region_subdiv input').val('Городские леса').prop('disabled', false);
        }

        else if ( $('#zakupcard-land_cat').val() == 4 ) {
            $('.field-zakupcard-region label').text( 'ООПТ' );
            $('.field-zakupcard-region_subdiv label').text( '' );
            $('.field-zakupcard-region_subdiv input').hide();
            // $('.field-zakupcard-region_subdiv input').prop('disabled', true);
        }
        else if ( $('#zakupcard-land_cat').val() == 5 ) {
            $('.field-zakupcard-region label').text( 'Иные  ' );
            $('.field-zakupcard-region_subdiv label').text( '' );
            $('.field-zakupcard-region_subdiv input').hide();
            // $('.field-zakupcard-region_subdiv input').prop('disabled', true);
        }

    }

    // Обновляем названия и состав полей при загрузке страницы
    regionLabel();

    // Обновляем названия и состав полей при изменении категории земель
    $('#zakupcard-land_cat').on('change', function() {
            regionLabel();
        });


    // Для Свода ФО и Филиалов
    $(".t1").parent().prev(".to1").text();
    $(".ttAll").css('display', 'none');
    let i = 0;
    while (i < $(".t1").length) { // выводит 0, затем 1, затем 2
        $(".t1:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".to1").text($(".t1:eq("+ i +")").text());
        $(".t2:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".to2").text($(".t2:eq("+i +")").text());
        $(".t3:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".to3").text($(".t3:eq("+i +")").text());
        $(".tt1:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".ttl1").text($(".tt1:eq("+i +")").text());
        $(".tt2:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".ttl2").text($(".tt2:eq("+i +")").text());
        $(".tt3:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".ttl3").text($(".tt3:eq("+i +")").text());
        $(".tt4:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".ttl4").text($(".tt4:eq("+i +")").text());
        $(".tt5:eq("+ i +")").parent().parent().prev(".tbodyXS").find(".ttl5").text($(".tt5:eq("+i +")").text());
        i++;
    }



    //********************************************************
    // Если отмечаем чекбокс Мы победители, то автоматически заносим наименование в поле и не даем его менять
    //********************************************************

    $('#winner_we').on('click', function() {

        if ( $(this).prop('checked') ) {
            $('#winner_name').val('ФГБУ "Рослесинфорг"');
            // $('#winner_name').attr('disabled', true);
        }
        else {
            $('#winner_name').val('');
            // $('#winner_name').attr('disabled', false);
        }

    });




    $('#price_final').on('change', function() {

        if ( $('#winner_we').prop('checked') ) {
            $('#price_rli').val( $('#price_final').val() );
        }

    });


});

function  transliterateRuEn(text ) {
    text = text
        .replace(/\u0429/g, 'SCH')  //Щ
        .replace(/\u0449/g, 'sch') //щ
        .replace(/\u0448/g, 'sh') //ш
        .replace(/\u0401/g, 'YO') //Ё
        .replace(/\u0419/g, 'IA') //Й
        .replace(/\u0426/g, 'TS') //Ц
        .replace(/\u0428/g, 'SH')  //Ш
        .replace(/\u0451/g, 'yo') // ё
        .replace(/\u0439/g, 'ia') //й
        .replace(/\u0446/g, 'ts') //ц
        .replace(/\u0416/g, 'ZH') //Ж
        .replace(/\u042D/g, 'EH') //Э
        .replace(/\u0436/g, 'zh') //ж
        .replace(/\u044D/g, 'eh') //э
        .replace(/\u042F/g, 'YA')  //Я
        .replace(/\u0427/g, 'CH')  //Ч
        .replace(/\u042E/g, 'YU')  //Ю
        .replace(/\u044F/g, 'ya') //я
        .replace(/\u0447/g, 'ch') //ч
        .replace(/\u044E/g, 'yu') //ю
        .replace(/\u0423/g, 'U') //У
        .replace(/\u041A/g, 'K') //К
        .replace(/\u0415/g, 'E') //Е
        .replace(/\u041D/g, 'N')  //Н
        .replace(/\u0413/g, 'G')  //Г
        .replace(/\u0417/g, 'Z')  //З
        .replace(/\u0425/g, 'H')  //Х
        // .replace(/\u042A/g, '"')  //Ъ
        .replace(/\u042A/g, '')  //Ъ
        .replace(/\u0443/g, 'u') //у
        .replace(/\u043A/g, 'k') //к
        .replace(/\u0435/g, 'e') //е
        .replace(/\u043D/g, 'n') //н
        .replace(/\u0433/g, 'g') //г
        .replace(/\u0437/g, 'z') //з
        .replace(/\u0445/g, 'h') //х
        // .replace(/\u044A/g, '"') //ъ
        .replace(/\u044A/g, '') //ъ
        .replace(/\u0424/g, 'F')  //Ф
        .replace(/\u042B/g, 'Y') //Ы
        .replace(/\u0412/g, 'V') //В
        .replace(/\u0410/g, 'A') //А
        .replace(/\u041F/g, 'P') //П
        .replace(/\u0420/g, 'R') //Р
        .replace(/\u041E/g, 'O') //О
        .replace(/\u041B/g, 'L') //Л
        .replace(/\u0414/g, 'D') //Д
        .replace(/\u0444/g, 'f') //ф
        .replace(/\u044B/g, 'y') //ы
        .replace(/\u0432/g, 'v') //в
        .replace(/\u0430/g, 'a') //а
        .replace(/\u043F/g, 'p') //п
        .replace(/\u0440/g, 'r') //р
        .replace(/\u043E/g, 'o') //о
        .replace(/\u043B/g, 'l') //л
        .replace(/\u0434/g, 'd') //д
        .replace(/\u0421/g, 'S')  //С
        .replace(/\u041C/g, 'M')  //М
        .replace(/\u0418/g, 'I')  //И
        .replace(/\u0422/g, 'T')  //Т
        // .replace(/\u042C/g, "'")  //Ь
        .replace(/\u042C/g, "")  //Ь
        .replace(/\u0411/g, 'B')  //Б
        .replace(/\u0441/g, 's') //с
        .replace(/\u043C/g, 'm') //м
        .replace(/\u0438/g, 'i') //и
        .replace(/\u0442/g, 't') //т
        // .replace(/\u044C/g, "'") //ь
        .replace(/\u044C/g, "") //ь
        .replace(/\u0431/g, 'b') //б
    ;
    return text;
}
function  transliterateEnRu(text) {
    text = text
        .replace(/\u0053\u0043\u0048/g, 'Щ') //SCH
        .replace(/\u0059\u004F/g , 'Ё') //YO
        .replace(/\u0049\u0041/g, 'Й') //IA
        .replace(/\u0054\u0053/g, 'Ц') //TS
        .replace(/\u0053\u0048/g, 'Ш') //SH
        .replace(/\u005A\u0048/g, 'Ж') //ZH
        .replace(/\u0045\u0048/g, 'Э') //EH
        .replace(/\u0059\u0041/g, 'Я')  //YA
        .replace(/\u0043\u0048/g, 'Ч')  //CH
        .replace(/\u0059\u0055/g, 'Ю')  //YU


        .replace(/\u0073\u0063\u0068/g, 'щ') //sch
        .replace(/\u0079\u0075/g, 'ю') //yu
        .replace(/\u0079\u0061/g, 'я') //ya
        .replace(/\u0063\u0068/g, 'ч') //ch
        .replace(/\u007A\u0068/g, 'ж') //zh
        .replace(/\u0065\u0068/g, 'э') //eh
        .replace(/\u0073\u0068/g, 'ш') //sh
        .replace(/\u0079\u006F/g, 'ё') // yo
        .replace(/\u0069\u0061/g, 'й') //ia
        .replace(/\u0074\u0073/g, 'ц') //ts
        .replace(/\u0055/g, 'У') // U
        .replace(/\u004B/g, 'К') // K
        .replace(/\u0045/g, 'Е') // E
        .replace(/\u004E/g, 'Н') // N
        .replace(/\u0047/g, 'Г') // G
        .replace(/\u005A/g, 'З') //Z
        .replace(/\u0048/g, 'Х') //H
        // .replace(/\u0022/g, 'ъ') //"
        .replace(/\u0075/g, 'у') //u
        .replace(/\u006B/g, 'к') //k
        .replace(/\u0065/g, 'е') //e
        .replace(/\u006E/g, 'н') //n
        .replace(/\u0067/g, 'г') //g
        .replace(/\u007A/g, 'з') //z
        .replace(/\u0068/g, 'х') //h
        // .replace(/\u0022/g, "ъ") //"
        .replace(/\u0046/g, 'Ф')  //F
        .replace(/\u0059/g, 'Ы') //Y
        .replace(/\u0056/g, 'В') //V
        .replace(/\u0041/g, 'А') //A
        .replace(/\u0050/g, 'П') //P
        .replace(/\u0052/g, 'Р') //R
        .replace(/\u004F/g, 'О') //O
        .replace(/\u004C/g, 'Л') //L
        .replace(/\u0044/g, 'Д') //D
        .replace(/\u0066/g, 'ф') //f
        .replace(/\u0079/g, 'ы') //y
        .replace(/\u0076/g, 'в') //v
        .replace(/\u0061/g, 'а') //a
        .replace(/\u0070/g, 'п') //p
        .replace(/\u0072/g, 'р') //r
        .replace(/\u006F/g, 'о') //o
        .replace(/\u006C/g, 'л') //l
        .replace(/\u0064/g, 'д') //d
        .replace(/\u0053/g, 'С')  //S
        .replace(/\u004D/g, 'М')  //M
        .replace(/\u0049/g, 'И')  //I
        .replace(/\u0054/g, 'Т')  //T
        // .replace(/\u0027/g, "ь")  //'
        .replace(/\u0042/g, 'Б')  //B
        .replace(/\u0073/g, 'с') //s
        .replace(/\u006D/g, 'м') //m
        .replace(/\u0069/g, 'и') //i
        .replace(/\u0074/g, 'т') //t
        // .replace(/\u0027/g, "ь") //'
        .replace(/\u0062/g, 'б') //b
    ;
    return text;
}